window.addEventListener('DOMContentLoaded', function(){
	const app = new Vue({
		el: '#app',
		data: {
			searchResults: [
				'asdf',
				'asdffdsa',
			],
		},
		methods: {
			updateSearch: function(){
				this.searchResults = [
					'lol',
					'test',
					'test2',
				];
			},
		},
	});
});