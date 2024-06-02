import { request } from '@/utils/request.js'

/**
 * 等级设置 API JS
 */

export default {

  /**
   * 获取等级设置分页列表
   * @returns
   */
  getList (params = {}) {
    return request({
      url: 'wxc/sharerLevel/index',
      method: 'get',
      params
    })
  },

  /**
   * 添加等级设置
   * @returns
   */
  save (data = {}) {
    return request({
      url: 'wxc/sharerLevel/save',
      method: 'post',
      data
    })
  },

  /**
   * 更新等级设置
   * @returns
   */
  update (id, data = {}) {
    return request({
      url: 'wxc/sharerLevel/update/' + id,
      method: 'put',
      data
    })
  },

  /**
   * 删除等级设置
   * @returns
   */
  deletes(data) {
    return request({
      url: 'wxc/sharerLevel/delete',
      method: 'delete',
      data
    })
  },

  remote (data) {
    return request({
      url: 'wxc/sharerLevel/remote',
      method: 'post',
      data
    })
  },
}