<template>
    <view :style="themeColor()">
        <scroll-view scroll-y="true" class="w-screen h-screen bg-page">
            <view class="h-[30rpx]"></view>
            <view class="p-[30rpx] bg-white mx-[32rpx] rounded">
                <block v-if="formData.account_type == 'bank'">
                    <view class="text-center text-base font-bold mt-[50rpx]">{{ t('addBankCard') }}</view>
                    <view class="text-center text-sm mt-[10rpx]">{{ t('addBankCardTips') }}</view>

                    <view class="mt-[50rpx]">
                        <u-form labelPosition="left" :model="formData" labelWidth="200rpx" errorType='toast' :rules="rules" ref="formRef">
                            <view class="mt-[10rpx]">
                                <u-form-item :label="t('bankRealname')" prop="realname" :border-bottom="true">
                                    <u-input v-model.trim="formData.realname" maxlength="30" border="none" clearable :placeholder="t('bankRealnamePlaceholder')"/>
                                </u-form-item>
                            </view>
                            <view class="mt-[10rpx]">
                                <u-form-item :label="t('bankName')" prop="bank_name" :border-bottom="true">
                                    <u-input v-model.trim="formData.bank_name" maxlength="30" border="none" clearable :placeholder="t('bankNamePlaceholder')"/>
                                </u-form-item>
                            </view>
                            <view class="mt-[10rpx]">
                                <u-form-item :label="t('bankAccountNo')" prop="account_no" :border-bottom="true">
                                    <u-input v-model.trim="formData.account_no" maxlength="30" border="none" clearable :placeholder="t('bankAccountNoPlaceholder')"/>
                                </u-form-item>
                            </view>
                        </u-form>
                    </view>
                </block>

                <block v-if="formData.account_type == 'alipay'">
                    <view class="text-center text-base font-bold mt-[50rpx]">{{ t('addAlipayAccount') }}</view>
                    <view class="text-center text-sm mt-[10rpx]">{{ t('addAlipayAccountTips') }}</view>

                    <view class="mt-[50rpx]">
                        <u-form labelPosition="left" :model="formData" labelWidth="200rpx" errorType='toast' :rules="rules" ref="formRef">
                            <view class="mt-[10rpx]">
                                <u-form-item :label="t('alipayRealname')" prop="realname" :border-bottom="true">
                                    <u-input v-model.trim="formData.realname" maxlength="30" border="none" clearable :placeholder="t('alipayRealnamePlaceholder')"/>
                                </u-form-item>
                            </view>
                            <view class="mt-[10rpx]">
                                <u-form-item :label="t('alipayAccountNo')" prop="account_no" :border-bottom="true">
                                    <u-input v-model.trim="formData.account_no" border="none" maxlength="30" clearable :placeholder="t('alipayAccountNoPlaceholder')"/>
                                </u-form-item>
                            </view>
                        </u-form>
                    </view>
                </block>

                <view class="mt-[100rpx]">
                    <u-button :text="t('save')" type="primary" shape="circle" :loading="loading" @click="handleSave"></u-button>
                </view>
            </view>
        </scroll-view>

        <u-modal :show="deleteConfirm" :content="t('deleteConfirm')" :confirmText="t('confirm')" :cancelText="t('cancel')" :showCancelButton="true" @confirm="handleDelete" @cancel="deleteConfirm = false"></u-modal>
    </view>
</template>

<script setup lang="ts">
    import { ref, computed, reactive } from 'vue'
    import { onLoad } from '@dcloudio/uni-app'
    import { getCashoutAccountInfo, addCashoutAccount, editCashoutAccount, deleteCashoutAccount } from '@/app/api/member'
    import { t } from '@/locale'
    import { redirect } from '@/utils/common'

    const loading = ref(false)
    const formRef = ref(null)
    const mode = ref('get')
    const deleteConfirm = ref(false)
    const formData = reactive<AnyObject>({
        account_id: 0,
        account_type: 'bank',
        bank_name: '',
        realname: '',
        account_no: ''
    })

    const rules = computed(() => {
        return {
            'realname': {
                type: 'string',
                required: true,
                message: formData.account_type == 'bank' ? t('bankRealnamePlaceholder') : t('alipayRealnamePlaceholder'),
                trigger: ['blur', 'change'],
            },
            'bank_name': {
                type: 'string',
                required: formData.account_type == 'bank',
                message: t('bankNamePlaceholder'),
                trigger: ['blur', 'change'],
            },
            'account_no': {
                type: 'string',
                required: true,
                message: formData.account_type == 'bank' ? t('bankAccountNoPlaceholder') : t('alipayAccountNoPlaceholder'),
                trigger: ['blur', 'change'],
            }
        }
    })

    onLoad((data) => {
        data.type && (formData.account_type = data.type)
        data.mode && (mode.value = data.mode)
        if (data.id) {
            formData.account_id = data.id

            getCashoutAccountInfo({ account_id: data.id }).then((res : responseResult) => {
                if (res.data) {
                    Object.keys(formData).forEach((key : string) => {
                        if (res.data[key] != undefined) formData[key] = res.data[key]
                    })
                }
            })
        }
    })

    const handleSave = () => {
        const save = formData.account_id ? editCashoutAccount : addCashoutAccount

        formRef.value.validate().then(() => {
            if (loading.value) return
            loading.value = true

            save(formData).then((res) => {
                if (mode.value == 'get') redirect({ url: '/app/pages/member/account', param: { type: formData.account_type, mode: mode.value } })
                else redirect({ url: '/app/pages/member/apply_cash_out', param: { account_id: formData.account_id ? formData.account_id : res.data.id, type: formData.account_type } , mode: 'redirectTo'})
            }).catch(() => {
                loading.value = false
            })
        })
    }

    const handleDelete = () => {
        deleteCashoutAccount(formData.account_id).then(() => {
            redirect({ url: '/app/pages/member/account', mode: 'redirectTo' })
        })
    }
</script>

<style lang="scss" scoped></style>
