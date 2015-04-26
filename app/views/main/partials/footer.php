	</div>
	</body>
	<script>
		$('.options-item').on('mouseenter mouseleave', function(){
			$('.options-item-dropdown').toggleClass('options-item-dropdown-open');
		});
		$('.search').on('click', function(){
			window.location.href = "/" + $('.search-val').val() + "";
		});
		
		/**
		*
		*	Error Handeling scripts
		*
		**/
		$('.error-remove').on("click", function(){
			$('.error, .warning').fadeOut();
		});
	</script>
</html>