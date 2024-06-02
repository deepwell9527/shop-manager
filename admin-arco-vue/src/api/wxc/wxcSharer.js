import { request } from '@/utils/request.js'

/**
 * 分享员 API JS
 */

export default {

  /**
   * 获取分享员分页列表
   * @returns
   */
  getList (params = {}) {
    return request({
      url: 'wxc/sharer/index',
      method: 'get',
      params
    })
  },

  /**
   * 绑定
   * @param params
   * @returns {*}
   */
  bind (params = {}) {
    return request({
      url: 'wxc/sharer/bind',
      method: 'post',
      params
    })
  },

  /**
   * 同步
   * @param params
   * @returns {*}
   */
  sync (params = {}) {
    return request({
      url: 'wxc/sharer/sync',
      method: 'post',
      params
    })
  },

  /**
   * 更新
   * @returns
   */
  updateSpec (data = {}) {
    return request({
      url: 'wxc/sharer/update/spec',
      method: 'put',
      data
    })
  },
}