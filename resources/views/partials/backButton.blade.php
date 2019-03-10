<div class="back-button">
	@if(backButton())
    	<a href="@php echo session('back-btn'); @endphp"><i class="fa fa-reply"></i> Volver</a>
    	<p></p>
    @endif
</div>