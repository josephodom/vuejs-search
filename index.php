<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/vue"></script> -->
<script type="text/javascript" src="search.js"></script>
<title>Vue.js Dictionary</title>
</head>

<body>

<header>
	<div class="container">
		<h1>
			Vue.js Dictionary
		</h1>
	</div>
</header>

<main id="app">
	<div class="container">
		<div class="card">
			<div class="card-body">
				<p>
					Want to find a word? Just search it!
				</p>
				
				<input type="text" name="s" class="form-control" placeholder="Keywords" v-on:change="updateSearch" v-on:keyup="updateSearch">
			</div>
		</div>
		
		
		
		<section v-if="searchResults.length">
			<ul class="results">
				<li v-for="result in searchResults">
					<div class="card">
						<div class="card-body">
							{{ result.word }}
						</div>
					</div>
				</li>
			</ul>
			
			<button type="button" class="btn btn-primary" v-on:click="loadMore" v-if="page < totalPages">
				Load More (Page {{ page }} of {{ totalPages }})
			</button>
		</section>
		
		
		
		<section v-if="!searchResults.length && searchTerm.length">
			<div class="card">
				<div class="card-body">
					No results!
				</div>
			</div>
		</section>
	</div><!-- .container -->
</main>

<footer>
	<div class="container">
		&copy; Joseph Odom <?=date('Y')?>
	</div>
</footer>

</body>

</html>