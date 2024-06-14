<template>
    <div class="py-16">
        <div class="container">
            <div class="chat-box__wrap h-full md:max-h-[565px]">
                <div class="flex flex-col gap-6 md:flex-row">
                    <div class="chat-list dark:bg-gray-900 md:min-w-[312px] border border-gray-50 dark:border-gray-600 rounded-lg overflow-hidden">
                        <div class="sm:p-6 p-3 border-b border-b-gray-50 dark:border-b-gray-600">
                            <h2 class="text-gray-900 dark:text-white">{{ __('message_list') }}</h2>
                        </div>

                        <ul class="pb-4 h-[500px] overflow-y-auto">
                            <li v-for="(user, index) in usersList" :key="index" @click="getMessages(user)" class="flex gap-4 items-center justify-between sm:px-6 px-3 py-2 cursor-pointer border-b border-primary-50 " :class="selectedUser.recipient_user_id == user.from_id || selectedUser.recipient_user_id == user.to_id ? 'bg-primary-400 text-white':'hover:bg-primary-50 hover:dark:bg-gray-700'">
                                <div v-if="user.to_id == auth.id" class="flex items-center gap-4">
                                    <img class="w-10 h-10 rounded-full" :src="user?.from?.image_url" alt="">
                                    <h3 class="text-gray-900 dark:text-white">{{ user?.from?.name }}</h3>
                                </div>
                                <div v-else class="flex items-center gap-4">
                                    <img class="w-10 h-10 rounded-full" :src="user?.to?.image_url" alt="">
                                    <h3 class="text-gray-900 dark:text-white">{{ user?.to?.name }}</h3>
                                </div>
                                <p class="dark:text-gray-300">{{ user?.human_time }}</p>
                            </li>
                        </ul>
                    </div>
                    <div id="chatbox_wrap" class="chat-box dark:bg-gray-900 overflow-hidden border border-gray-50 dark:border-gray-600 rounded-lg flex-grow" v-if="selectedUser">
                        <template v-if="auth.id == selectedUser.to_id">
                            <div class="flex gap-4 items-center sm:px-6 px-3 py-3 bg-primary-50 dark:bg-gray-700">
                                <img class="w-10 h-10 rounded-full" :src="selectedUser?.from?.image_url" :alt="selectedUser?.from?.name">
                                <h3 class="dark:text-white">{{ selectedUser?.from?.name }}</h3>
                            </div>
                        </template>
                        <template v-else>
                            <div class="flex gap-4 items-center sm:px-6 px-3 py-3 bg-primary-50 dark:bg-gray-700">
                                <img class="w-10 h-10 rounded-full" :src="selectedUser?.to?.image_url" :alt="selectedUser?.to?.name">
                                <h3>{{ selectedUser?.to?.name }}</h3>
                            </div>
                        </template>
                        <div class="h-[405px] overflow-y-auto sm:p-6 p-3" ref="chatbox">
                            <div v-for="(message, index) in messages" :key="index">
                                <div v-if="message.from_id == auth.id" class="send-message flex justify-end mb-3">
                                    <div class="max-w-[70%] flex flex-col gap-1">
                                        <p class="body-xs-400 flex gap-1 items-center text-gray-700 dark:text-gray-300">
                                            <span>{{ message.created_time }}</span>
                                        </p>
                                        <p class="p-2.5 body-sm-400 text-gray-900 dark:text-white rounded rounded-br-none bg-primary-50 dark:bg-gray-700">
                                            {{ message.body }}
                                        </p>

                                    </div>
                                </div>
                                <div v-else class="receive-message flex justify-start mb-3">
                                    <div v-if="selectedUser.to_id == auth.id" class="max-w-[70%] flex gap-2">
                                        <img class="w-10 h-10 rounded-full object-cover"
                                            :src="selectedUser?.from?.image_url" :alt="selectedUser?.from?.name">
                                        <div class="flex flex-col gap-1">
                                            <p class="body-xs-400 flex gap-1 items-center text-gray-700 dark:text-gray-300">
                                                <span>{{ selectedUser?.from?.name }}</span>
                                                <span>{{ message.created_time }}</span>
                                            </p>
                                            <p class="p-2.5 body-sm-400 text-gray-900 dark:text-white rounded rounded-bl-none bg-gray-50 dark:bg-gray-700">
                                                {{ message.body }}
                                            </p>
                                        </div>
                                    </div>
                                    <div v-else class="max-w-[70%] flex gap-2">
                                        <img class="w-10 h-10 rounded-full object-cover"
                                            :src="selectedUser?.to?.image_url" :alt="selectedUser?.to?.name">
                                        <div class="flex flex-col gap-1">
                                            <p class="body-xs-400 flex gap-1 items-center text-gray-700">
                                                <span>{{ selectedUser?.to?.name }}</span>
                                                <span>{{ message.created_time }}</span>
                                            </p>
                                            <p class="p-2.5 body-sm-400 text-gray-900 rounded rounded-bl-none bg-gray-50 dark:bg-gray-700">
                                                {{ message.body }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form @submit.prevent="sendMessage" class="w-full sm:p-6 p-3 border-t border-gray-50 dark:border-gray-700">
                            <div class="flex gap-4 items-center">
                                <input v-model="message" type="text" placeholder="Type your message..." class="tc-input">
                                <button :disabled="loading || !message.trim()" type="submit" class="btn-primary">
                                    <span class="hidden sm:inline-block">{{ __('send') }}</span>
                                    <loading-icon v-if="loading" />
                                    <send-icon v-else />
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="chat-box dark:bg-gray-900 p-12 border border-gray-50 dark:border-gray-600 rounded-lg flex justify-center items-center flex-grow" v-else>
                        <div class="text-center flex flex-col justify-center items-center">
                            <NotFoundIcon />
                            <h5 class="mt-4 dark:text-white">{{ __('no_message_selected') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LoadingIcon from './SvgIcon/LoadingIcon.vue';
import SendIcon from './SvgIcon/SendIcon.vue';
import NotFoundIcon from './SvgIcon/NotFoundIcon.vue';

export default {
    components: {
        LoadingIcon,
        SendIcon,
        NotFoundIcon
    },
    props: {
        users: Array,
        auth: Object,
    },
    data() {
        return {
            languageTranslation: [],
            messages: [],
            selectedUser: '',
            selectedUserId: '',
            message: '',
            usersList: this.users,
            loading: false,
        }
    },
    methods: {

        scrollToBottom() {
            this.$nextTick(function () {
                var container = this.$refs.chatbox;
                container.scrollTop = container?.scrollHeight;
            });
        },
        async getMessages(user) {
            this.message = ''
            this.messages = []
            this.selectedUser = user

            await this.$nextTick();

            const section = document.getElementById("chatbox_wrap");
            console.log(section);
            if (section) {
                window.scroll({
                    behavior: 'smooth',
                    left: 0,
                    top: section.offsetTop
                });
            }

            if (user.from_id == this.auth.id) {
                var username = user?.to?.username || null
            }else{
                var username = user?.from?.username || null
            }




            if (user.to_id == this.auth.id) {
                var username = user?.from?.username || null
            }else{
                var username = user?.to?.username || null
            }

            let response = await axios.get('/dashboard/get/messages/' + username)
            this.messages = response.data

        },
        async sendMessage(e) {
            if (!this.message.length || this.loading) { return; }
            this.loading = true

            if (this.auth.id == this.selectedUser.to_id) {
                var to_id = this.selectedUser.from_id || null
            }else{
                var to_id = this.selectedUser.to_id || null
            }

            if (!to_id) { alert('User not found'); return; }

            try {
                let response = await axios.post('/dashboard/send/message', {
                    message: this.message,
                    to: to_id,
                    chat_id: this.selectedUser.id,
                })

                this.messages.push(response.data)
                this.message = ''
                this.scrollToBottom();
                this.loading = false
                this.syncMessageUserList();
            } catch (error) {
                alert('Something went wrong');
            }
        },
        __(key) {
            if (this.languageTranslation) {
                return this.languageTranslation[key] || key;
            }

            return key;
        },
        async syncMessageUserList(){
            let response = await axios.get('/dashboard/sync/user-list')
            this.usersList = response.data
        },
        playAudio() {
            const sound = new Audio('/frontend/sound.mp3')
            sound.play()
        },
         async fetchTranslateData() {
            let data = await axios.get('/translated/texts');
            this.languageTranslation = data.data
        },
    },
    updated() {
        this.scrollToBottom();
    },
    mounted() {
        this.fetchTranslateData()

        Echo.private('chat')
            .listen('ChatMessage', (e) => {
                if (e.chatMessage.to_id == this.auth.id) {
                    this.playAudio();
                    this.messages.push(e.chatMessage);
                    this.syncMessageUserList();
                }
            });
    }
}
</script>
