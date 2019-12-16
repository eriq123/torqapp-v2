+<template>
<ul class="notifications" v-on:click="markNotificationAsRead">
    <li>
        <a href="#" type="button" role="button" class="dropdown-toggle notification-icon" data-toggle="dropdown">
            <i class="fa fa-bell"></i>
            <span class="badge">{{unreadNotifications.length}}</span>
        </a>

        <div class="dropdown-menu notification-menu">
            <div class="notification-title">
                Notifications
            </div>

            <div class="nano" style="padding: 6px; height: 150px!important;">
                <div class="nano-content nano-right">
                    <ul>
                        <li style="margin: 0 0 0 12px; color: #D3D3D3;">
                            <unread-items v-for="unread in unreadNotifications" :unread="unread" v-bind:key="unread.id"></unread-items>
                        </li>

                        <li style="margin: 0 0 0 12px;">
                            <read-items v-for="read in notifications" :read="read" v-bind:key="read.id"></read-items>
                        </li>
                    </ul>

                    <hr>

                    <div class="text-right" style="margin-right: 6px; margin-bottom: 6px;">
                        <a href="" class="view-more">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </li>
</ul>
</template>

<script>
    export default {
        props: [
            'userid',
            'unread',
            'read'
        ],
        methods: {
            markNotificationAsRead(){
                if (this.unreadNotifications.length) {
                    axios.get('/markasread')
                         .then(response => console.log(response))
                         .catch(error => console.log(error.response));
                }
            },
        },
        data(){
            return {
                unreadNotifications: this.unread,
                notifications: this.read
            }
        },
        mounted() {

            setTimeout(function () {
                $(".nano").nanoScroller();
            }, 100);

           Echo.private('App.User.' + this.userid)
                .notification((res) => {
                    console.log(res);
                    let newunreadNotification = {
                        data:{
                            sender_id: res.sender_id, 
                            ppmp_id: res.ppmp_id, 
                            type: res.type,
                            sender_name: res.sender_name,
                            description: res.description
                        }
                    };
                    this.unreadNotifications.push(newunreadNotification);
                });
        },
    }
</script>
<style scoped>
    .nano-right {
        right: 0px!important;
    }
</style>