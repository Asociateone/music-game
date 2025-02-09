<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Chat Room</div>
                    <div class="card-body" style="height: 400px; overflow-y: scroll;">
                        <ul class="list-unstyled">
                            <li v-for="message in messages" :key="message.id">
                                <strong>{{ message.user.name }}:</strong> {{ message.message }}
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <input type="text" class="form-control" v-model="newMessage" @keyup.enter="sendMessage">
                        <button class="btn btn-primary mt-2" @click="sendMessage">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            messages: [],
            newMessage: ''
        };
    },
    mounted() {
        this.fetchMessages();
        Echo.join('chat')
            .here((users) => {
                console.log('Users online:', users);
            })
            .joining((user) => {
                console.log(user.name + ' joined.');
            })
            .leaving((user) => {
                console.log(user.name + ' left.');
            })
            .listen('MessageSent', (e) => {
                this.messages.push(e.message);
            });
    },
    methods: {
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data;
            });
        },
        sendMessage() {
            if (this.newMessage === '') {
                return;
            }
            axios.post('/messages', { message: this.newMessage }).then(response => {
                this.newMessage = '';
            });
        }
    }
};
</script>
