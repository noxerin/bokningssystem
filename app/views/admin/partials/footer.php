	</div>
	</body>
	<script>
		$('.options-item').on('mouseenter mouseleave', function(){
			$(this).find('.options-item-dropdown').toggleClass('options-item-dropdown-open');
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