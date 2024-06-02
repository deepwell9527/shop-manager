import { request } from '@/utils/request.js'

/**
 * 店铺管理 API JS
 */

export default {

  /**
   * 获取店铺管理分页列表
   * @returns
   */
  getList (params = {}) {
    return request({
      url: 'wxc/shop/index',
      method: 'get',
      params
    })
  },

  /**
   * 添加店铺管理
   * @returns
   */
  save (data = {}) {
    return request({
      url: 'wxc/shop/save',
      method: 'post',
      data
    })
  },

  /**
   * 更新店铺管理数据
   * @returns
   */
  update (id, data = {}) {
    return request({
      url: 'wxc/shop/update/' + id,
      method: 'put',
      data
    })
  },

  /**
   * 将店铺管理删除，有软删除则移动到回收站
   * @returns
   */
  deletes (data) {
    return request({
      url: 'wxc/shop/delete',
      method: 'delete',
      data
    })
  },

  /**
   * 读取店铺管理
   * @returns
   */
  read (id) {
    return request({
      url: 'wxc/shop/read/' + id,
      method: 'get',
    })
  },

  /**
   * 读取店铺数据列表
   * @returns
   */
  remote (data) {
    return request({
      url: 'wxc/shop/remote',
      method: 'post',
      data
    })
  },

}