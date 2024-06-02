import {defineStore} from 'pinia'
import wxcShop from "@/api/wxc/wxcShop.js";
import wxcSharerLevel from "@/api/wxc/wxcSharerLevel.js";

// 租户site状态
const useSiteStore = defineStore('site', {
    state: () => ({
            shopDict: [],
            isGettingShopDict: false,
            sharerLevelDict: [],
        }
    ),

    getters: {
        getState() {
            return {...this.$state}
        },
        getShopDict: (state) => {
            return state.shopDict
        }
    },

    actions: {
        /**
         * 获取当前租户已添加的视频号小店字典数据
         */
        async fetchShopDict() {
            if (!this.shopDict.length) {
                // 通过api获取当前租户已添加的视频号小店
                const res = await wxcShop.remote({
                    // 设置查询的字段
                    select: ['app_id', 'shop_id'],
                    // 关联模型
                    relations: [
                        // 定义关联
                        {
                            name: 'basicInfo', // 关联名
                            model: 'App.Wxc.Model.WxcShopInfo', // 关联模型的命名空间，使用 . 代替 \，可咨询后端人员
                            type: 'hasOne', // 关联类型，hasOne：一对一，hasMany：一对多，belongsTo：一对多（反向），belongsToMany：多对多
                            foreignKey: 'shop_id',
                            localKey: 'shop_id',
                        },
                    ]
                })
                if (res.code === 200 && res.success) {
                    const shopList = res.data ?? []
                    for (const idx in shopList) {
                        this.shopDict.push({
                            label: shopList[idx].basic_info.nickname,
                            value: shopList[idx].app_id
                        })
                    }
                }
            }
            return this.shopDict
        },
        /**
         * 获取当前租户已添加的等级身份字典数据
         */
        async fetchSharerLevelDict() {
            if (!this.sharerLevelDict.length) {
                // 通过api获取当前租户已添加的视频号小店
                const res = await wxcSharerLevel.remote({
                    // 设置查询的字段
                    select: ['level_id', 'title', 'first_tier_rate', 'sec_tier_rate'],
                })
                if (res.code === 200 && res.success) {
                    const datalist = res.data ?? []
                    for (const idx in datalist) {
                        this.sharerLevelDict.push({
                            label: datalist[idx].title + '(' + datalist[idx].desc + ')',
                            value: datalist[idx].level_id
                        })
                    }
                }
            }
            return this.sharerLevelDict
        },
    }
})

export default useSiteStore
