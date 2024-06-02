import {useSiteStore} from "@/store/index.js";

export default {
    app_id: {
        title: "所属店铺",
        dataIndex: "app_id",
        formType: "select",
        search: true,
        dict: {
            data: () => {
                const siteStore = useSiteStore()
                return siteStore.fetchShopDict()
            },
            translation: true
        },
        editDisabled: true,
    },
}