<template>

	<a href="#" class="clearfix" style="margin-bottom: 8px; margin-top: 8px; border-bottom: solid black;">
		<span class="title">{{unread.data.sender_name}}</span>
		<span class="message">{{unread.data.description}}</span>
	</a>

</template>
<script>
	export default {
		props: [
			'unread'
		],
		data(){
			return {
				
			}
		},


	}
</script>
