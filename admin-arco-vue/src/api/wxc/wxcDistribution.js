import { request } from '@/utils/request.js'

/**
 * 分销设置 API JS
 */

export default {

  /**
   * 获取分销设置分页列表
   * @returns
   */
  getList (params = {}) {
    return request({
      url: 'wxc/distribution/index',
      method: 'get',
      params
    })
  },

  /**
   * 更新分销设置
   * @returns
   */
  update (data = {}) {
    return request({
      url: 'wxc/distribution/update',
      method: 'put',
      data
    })
  },


}