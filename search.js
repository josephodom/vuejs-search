window.addEventListener('DOMContentLoaded', function(){
	const app = new Vue({
		el: '#app',
		data: {
			searchResults: [],
			searchTerm: false,
			page: 1,
			totalPages: 0,
			totalResults: 0,
		},
		methods: {
			loadMore: function(){
				this.page++;
				
				axios({
					method: 'get',
					url: `api.php?s=${document.querySelector('[name="s"]').value}&page=${this.page}`,
				}).then(response => {
					if(!response.data.success){
						this.searchResults = [];
						
						return;
					}
					
					const results = response.data.data.results;
					
					for(let i in results){
						this.searchResults.push(results[i]);
					}
				});
			},
			
			updateSearch: function(){
				this.searchTerm = document.querySelector('[name="s"]').value;
				this.page = 1;
				
				axios({
					method: 'get',
					url: `api.php?s=${document.querySelector('[name="s"]').value}`,
				}).then(response => {
					if(!response.data.success){
						this.searchResults = [];
						
						return;
					}
					
					this.searchResults = response.data.data.results;
					this.totalPages = response.data.data.totalPages;
					this.totalResults = response.data.data.totalResults;
				});
			},
		},
	});
});