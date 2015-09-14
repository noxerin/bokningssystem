	</div>
	</body>
	<script>
		$('.options-item').on('mouseenter mouseleave', function(){
			$(this).find('.options-item-dropdown').slideToggle('options-item-dropdown-open');
		});
			
			
		$('.accept').on("click", function(e){
			if (confirm('Är du säker?')) {
		    	
			} else {
			    e.preventDefault();
			}
		});
		
		$('a').on("click", function(e){
			$('.fa-cog').addClass('fa-spin');
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