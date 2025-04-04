<template>
    <el-dialog v-model="showDialog" :title="t('upgrade.title')" width="850px" :close-on-click-modal="false" :close-on-press-escape="false" :before-close="dialogClose">

        <div v-show="active == 'content'">

            <div class="h-[60vh] flex flex-col" v-if="upgradeContent">
                <div class="text-lg">
                    本次升级将从<span class="font-bold">{{ upgradeContent.version }}</span>升级到<span class="font-bold">{{ upgradeContent.upgrade_version }}</span>版本
                </div>
                <div class="mt-[10px]" v-if="upgradeContent.upgrade_version != upgradeContent.last_version">
                    <el-alert type="info" show-icon>
                        <template #title>
                            当前最新版本为{{ upgradeContent.last_version }}，您的服务{{ upgradeContent.expire_time ? `已于${upgradeContent.expire_time}到期` : '长期有效' }}。如需升级到最新版可在<a class="text-primary" href="https://www.niucloud.com" target="_blank">niucloud-admin官网</a>购买相关服务后再进行升级
                        </template>
                    </el-alert>
                </div>
                <el-scrollbar class="flex-1 h-0 mt-[20px]">
                    <div class="mt-[20px]" v-for="(item, index) in upgradeContent.version_list" :key="index">
                        <div class="font-bold text-lg">{{ item.version_no }}</div>
                        <div class="mt-[5px]" v-if="item.release_time">{{ item.release_time }}</div>
                        <div class="mt-[10px] p-[10px] rounded bg-[#f4f4f5] whitespace-pre-wrap !break-all" v-if="item.upgrade_log" v-html="item.upgrade_log"></div>
                    </div>
                </el-scrollbar>
            </div>
            <div class="flex justify-end" v-if="upgradeContent.version_list.length">
                <el-button type="primary" @click="handleUpgrade" :loading="uploading">{{ t('upgrade.upgradeButton') }}</el-button>
            </div>
        </div>

        <div v-show="active == 'upgrade'">
            <div class="h-[60vh] flex flex-col" v-if="upgradeCheck && !upgradeTask">
                <el-scrollbar>
                    <div class="bg-[#fff] my-3" v-if="upgradeCheck.dir">
                        <p class="pt-[20px] pl-[20px] ">{{ t('upgrade.dirPermission') }}</p>
                        <div class="px-[20px] pt-[10px] text-[14px] el-table">
                            <el-row class="py-[10px] items table-head-bg pl-[15px] mb-[10px]">
                                <el-col :span="12">
                                    <span>{{ t('upgrade.path') }}</span>
                                </el-col>
                                <el-col :span="6">
                                    <span>{{ t('upgrade.demand') }}</span>
                                </el-col>
                                <el-col :span="6">
                                    <span>{{ t('status') }}</span>
                                </el-col>
                            </el-row>
                            <el-row class="pb-[10px] items pl-[15px]" v-for="item in upgradeCheck.dir.is_readable">
                                <el-col :span="12">
                                    <span>{{ item.dir }}</span>
                                </el-col>
                                <el-col :span="6">
                                    <span>{{ t('upgrade.readable') }}</span>
                                </el-col>
                                <el-col :span="6">
                                    <span v-if="item.status"><el-icon color="green"><Select /></el-icon></span>
                                    <span v-else>
                                        <el-icon color="red">
                                            <CloseBold />
                                        </el-icon>
                                    </span>
                                </el-col>
                            </el-row>
                            <el-row class="pb-[10px] items pl-[15px]" v-for="item in upgradeCheck.dir.is_write">
                                <el-col :span="12">
                                    <span>{{ item.dir }}</span>
                                </el-col>
                                <el-col :span="6">
                                    <span>{{ t('upgrade.write') }}</span>
                                </el-col>
                                <el-col :span="6">
                                    <span v-if="item.status"><el-icon color="green"><Select /></el-icon></span>
                                    <span v-else>
                                        <el-icon color="red">
                                            <CloseBold />
                                        </el-icon>
                                    </span>
                                </el-col>
                            </el-row>
                        </div>
                    </div>
                </el-scrollbar>
            </div>
            <div class="h-[60vh]" v-show="upgradeTask">
                <terminal ref="terminalRef" :context="upgradeTask ? upgradeTask.upgrade.app_key : ''" :init-log="null" :show-header="false" :show-log-time="true" @exec-cmd="onExecCmd"/>
            </div>
        </div>

        <div v-show="active == 'complete'">
            <div class="h-[60vh] flex flex-col">
                <div class="flex-1 h-0">
                    <el-result icon="success" :title="t('upgrade.upgradeSuccess')"></el-result>
                    <el-alert :title="t('upgrade.upgradeCompleteTips')" type="error" :closable="false" />
                </div>
                <div class="flex justify-end">
                    <el-button type="default" @click="showDialog = false">{{ t('upgrade.localBuild') }}</el-button>
                    <el-button type="primary" @click="handleCloudBuild">{{ t('upgrade.cloudBuild') }}</el-button>
                </div>
            </div>
        </div>
    </el-dialog>

    <el-dialog v-model="upgradeTipsShowDialog" :title="t('warning')" width="500px" draggable>
        <span v-html="t('upgrade.upgradeTips')"></span>
        <template #footer>
            <div class="flex justify-end">
                <el-button @click="upgradeTipsConfirm(true)" type="primary">{{ t('upgrade.knownToKnow') }}</el-button>
                <el-button @click="upgradeTipsConfirm()" type="primary" plain>{{ t('upgrade.upgradeButton') }}</el-button>
                <el-button @click="upgradeTipsShowDialog = false">{{ t('cancel') }}</el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup>
import { ref, h, watch } from 'vue'
import { t } from '@/lang'
import { getVersions } from '@/app/api/auth'
import { getFrameworkNewVersion } from '@/app/api/module'
import { getUpgradeContent, getUpgradeTask, upgradeAddon, executeUpgrade, preUpgradeCheck, clearUpgradeTask } from '@/app/api/upgrade'
import { Terminal, TerminalFlash } from 'vue-web-terminal'
import 'vue-web-terminal/lib/theme/dark.css'
import { AnyObject } from '@/types/global'
import { ElNotification, ElMessage, ElMessageBox } from 'element-plus'
import Storage from '@/utils/storage'

const showDialog = ref<boolean>(false)
const upgradeContent = ref<null | AnyObject>(null)
const upgradeTask = ref<null | AnyObject>(null)
const active = ref('content')
const upgradeCheck = ref<null | AnyObject>(null)
const uploading = ref(false)
const terminalRef: any = ref(null)
const emits = defineEmits(['complete', 'cloudbuild'])
const upgradeTipsShowDialog = ref<boolean>(false)

let upgradeLog: any = []
let errorLog: any = []
/**
 * 查询升级任务
 */
const getUpgradeTaskFn = () => {
    getUpgradeTask().then(({ data }) => {
        if (!data) return

        // 检测有没有正在进行中的升级任务
        if (!showDialog.value) {
            showElNotification()
            return
        }
        if (!upgradeTask.value) {
            terminalRef.value.execute('clear')
            terminalRef.value.execute('开始升级')
        }
        data.log.forEach(item => {
            if (!upgradeLog.includes(item)) {
                terminalRef.value.pushMessage({content: `正在执行：${item}`})
                upgradeLog.push(item)
            }
        })
        // 安装失败
        if (data.error) {
            data.error.forEach(item => {
                if (!errorLog.includes(item)) {
                    terminalRef.value.pushMessage({ content: item, class: 'error' })
                    errorLog.push(item)
                }
            })
        }
        // 恢复完毕
        if (data.step == 'restoreComplete') {
            return
        }
        // 升级完成
        if (data.step == 'upgradeComplete') {
            active.value = 'complete'
            notificationEl && notificationEl.close()
            emits('complete')
            clearUpgradeTask()
            return
        }
        upgradeTask.value = data
        executeUpgradeFn()
    }).catch()
}
getUpgradeTaskFn()

const executeUpgradeFn = () => {
    executeUpgrade().then(() => {
        getUpgradeTaskFn()
    }).catch()
}

let notificationEl : any = null
/**
 * 升级中任务提示
 */
const showElNotification = () => {
    notificationEl = ElNotification.success({
        title: t('warning'),
        dangerouslyUseHTMLString: true,
        message: h('div', {}, [
            t('upgrade.upgradingTips'),
            h('span', { class: 'text-primary cursor-pointer', onClick: elNotificationClick }, [t('upgrade.clickView')])
        ]),
        duration: 0,
        showClose: false
    })
}

const elNotificationClick = () => {
    showDialog.value = true
    active.value = 'upgrade'
    getUpgradeTaskFn()
    notificationEl && notificationEl.close()
}

const frameworkVersion = ref('')
getVersions().then(res => {
    frameworkVersion.value = res.data.version.version
})
const newFrameworkVersion = ref("")
getFrameworkNewVersion().then(({ data }) => {
    newFrameworkVersion.value = data.last_version
})

/**
 * 执行升级
 */
const handleUpgrade = async () => {
    if (uploading.value) return
    uploading.value = true

    const appKey = upgradeContent.value?.app.app_key != 'niucloud-admin' ? upgradeContent.value?.app.app_key : ''

    await preUpgradeCheck(appKey).then(async({ data }) => {
        if (data.is_pass) {
            await upgradeAddon(appKey).then(() => {
                getUpgradeTaskFn()
            }).catch(() => {
                uploading.value = false
            })
        } else {
            upgradeCheck.value = data
        }
    }).catch()

    if (uploading.value) active.value = 'upgrade'
}

const open = (addonKey: string = '') => {
    if (upgradeTask.value) {
        ElMessage({ message: '已有正在执行中的升级任务', type: 'error' })
        showDialog.value = true
    } else {
        if (addonKey && frameworkVersion.value != newFrameworkVersion.value) {
            ElMessage({ message: '存在新版本框架，请先升级框架', type: 'error' })
            return
        }
        getUpgradeContent(addonKey).then(({ data }) => {
            upgradeContent.value = data
            if (Storage.get('upgradeTipsLock')) {
                showDialog.value = true
            } else {
                upgradeTipsShowDialog.value = true
            }
        }).catch()
    }
}

/**
 * 升级进度动画
 */
let flashInterval: any = null
const terminalFlash = new TerminalFlash()
const onExecCmd = (key, command, success, failed, name) => {
    if (command == '开始升级') {
        success(terminalFlash)
        const frames = makeIterator(['/', '——', '\\', '|'])
        flashInterval = setInterval(() => {
            terminalFlash.flush('> ' + frames.next().value)
        }, 150)
    }
}

const makeIterator = (array: string[]) => {
    var nextIndex = 0
    return {
        next() {
            if ((nextIndex + 1) == array.length) {
                nextIndex = 0
            }
            return { value: array[nextIndex++] }
        }
    }
}

const dialogClose = (done: () => {}) => {
    if (active.value == 'upgrade' && upgradeTask.value && !upgradeTask.value.error) {
        ElMessageBox.confirm(
            t('upgrade.showDialogCloseTips'),
            t('warning'),
            {
                confirmButtonText: t('confirm'),
                cancelButtonText: t('cancel'),
                type: 'warning'
            }
        ).then(() => {
            done()
        }).catch(() => { })
    } else {
        done()
    }
}

watch(() => showDialog.value, () => {
    if (!showDialog.value) {
        clearUpgradeTaskFn()
    }
})

const clearUpgradeTaskFn = () => {
    active.value = 'content'
    uploading.value = false
    upgradeTask.value = null
    upgradeLog = []
    errorLog = []
    flashInterval && clearInterval(flashInterval)
    clearUpgradeTask().then(() => {}).catch()
}

/**
 * 云编译
 */
const handleCloudBuild = () => {
    showDialog.value = false
    emits('cloudbuild')
}

const upgradeTipsConfirm = (isLock: boolean = false) => {
    isLock && Storage.set({ key: 'upgradeTipsLock', data: isLock })
    upgradeTipsShowDialog.value = false
    !isLock && (showDialog.value = true)
}

defineExpose({
    open
})
</script>

<style lang="scss" scoped>
.table-head-bg {
    background-color: var(--el-table-header-bg-color);
}
:deep(.terminal .t-log-box span) {
    white-space: pre-wrap;
}
</style>
