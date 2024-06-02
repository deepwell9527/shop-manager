import { request } from '@/utils/request.js'

/**
 * 订单 API JS
 */

export default {

  /**
   * 获取订单分页列表
   * @returns
   */
  getList (params = {}) {
    return request({
      url: 'wxc/order/index',
      method: 'get',
      params
    })
  },

  /**
   * 读取订单
   * @returns
   */
  read (id) {
    return request({
      url: 'wxc/order/read/' + id,
      method: 'get',
      data
    })
  },

  /**
   * 订单导出
   * @returns
   */
  exportExcel (params = {}) {
    return request({
      url: 'wxc/order/export',
      method: 'post',
      responseType: 'blob',
      params
    })
  },

  /**
   * 订单同步
   * @param params
   * @returns {*}
   */
  sync (params = {}) {
    return request({
      url: 'wxc/order/sync',
      method: 'post',
      params
    })
  },

}