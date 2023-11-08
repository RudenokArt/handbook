
<div id="app">
	<div class="mesage">{{ message }}</div>
	<example-component v-bind:example="example"></example-component>
</div>

<div id="example-component">{{example}}</div>

<script>
  var ExampleApp = Vue.createApp({
    data () {
    	return {
    		message: 'hello',
    		example: 'example-data',
    	};
    }
  });

ExampleApp.component('example-component', {
	template: '#example-component',
	props: ['example'],
});

ExampleApp.mount('#app');
</script>