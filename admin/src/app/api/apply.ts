import request from '@/utils/request'

/**
 * 应用列表
 * @returns
 */
export function getApply(params: Record<string, any>) {
    return request.get(`auth/authaddon`, {params})
}

export function getAppManage(params: Record<string, any>) {
    return request.get(`auth/app_manage`, {params})
}
