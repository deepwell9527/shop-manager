import {createPinia} from 'pinia'
import useUserStore from './modules/user'
import useAppStore from './modules/app'
import useTagStore from './modules/tag'
import useKeepAliveStore from './modules/keepAlive'
import useIframeStore from './modules/iframe'
import useConfigStore from './modules/config'
import useMessageStore from './modules/message'
import useDocStore from './modules/doc'
import useFormStore from './modules/form'
import useSiteStore from "./modules/site";

const pinia = createPinia()

export {
    useUserStore,
    useAppStore,
    useTagStore,
    useKeepAliveStore,
    useIframeStore,
    useConfigStore,
    useMessageStore,
    useDocStore,
    useFormStore,
    useSiteStore,
}
export default pinia
