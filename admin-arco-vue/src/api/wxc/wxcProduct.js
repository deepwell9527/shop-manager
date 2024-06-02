import {request} from '@/utils/request.js'

/**
 * 商品管理 API JS
 */

export default {

    /**
     * 获取商品管理分页列表
     * @returns
     */
    getList(params = {}) {
        return request({
            url: 'wxc/product/index',
            method: 'get',
            params
        })
    },

    /**
     * 将商品管理删除，有软删除则移动到回收站
     * @returns
     */
    deletes(data) {
        return request({
            url: 'wxc/product/delete',
            method: 'delete',
            data
        })
    },

    /**
     * 更改商品管理数据
     * @returns
     */
    changeStatus(data = {}) {
        return request({
            url: 'wxc/product/changeStatus',
            method: 'put',
            data
        })
    },

    /**
     * 同步商品
     * @returns
     */
    syncProduct() {
        return request({
            url: 'wxc/product/sync',
            method: 'post',
        })
    },

    /**
     * 更新
     * @returns
     */
    updateSpec (data = {}) {
        return request({
            url: 'wxc/product/update/spec',
            method: 'put',
            data
        })
    },

}