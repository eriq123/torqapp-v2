<template>

	<a href="#" class="clearfix" style="margin-bottom: 8px; margin-top: 8px; border-bottom: solid black;">
		<span class="title">{{read.data.sender_name}}</span>
		<span class="message">{{read.data.description}}</span>
	</a>

</template>
<script>
	export default {
		props: [
			'read'
		],
		data(){
			return {
				
			}
		},


	}
</script>
