import { request } from '@/utils/request.js'

/**
 * 售后管理 API JS
 */

export default {

  /**
   * 获取售后管理分页列表
   * @returns
   */
  getList (params = {}) {
    return request({
      url: 'wxc/afterSale/index',
      method: 'get',
      params
    })
  },

  /**
   * 读取售后管理
   * @returns
   */
  read (id) {
    return request({
      url: 'wxc/afterSale/read/' + id,
      method: 'get',
      data
    })
  },


}