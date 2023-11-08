<div id="app">
	<div class="mesage">{{ message }}</div>
	<example-component v-on:emitexample="emitHandler"></example-component>
</div>

<div id="example-component">
	<button v-on:click="emitTrigger">emit</button>
</div>

<script>
	var ExampleApp = Vue.createApp({
		data () {
			return {
				message: 'hello',
				example: 'example-data',
			};
		},
		methods: {
			emitHandler: function (text) {
				alert(text);
			}
		},
	});

	ExampleApp.component('example-component', {
		template: '#example-component',
		emits: ['emitexample'],
		methods: {
			emitTrigger: function () {
				this.$emit('emitexample', '! emit works !');
			}
		}
	});

	ExampleApp.mount('#app');
</script>