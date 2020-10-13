<div class="modal fade bs-example-modal-lg" id="review-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form action="{{ route('review.post') }}" method="post">
				{{ csrf_field() }}
				<input type="hidden" name="product_id" value="{{$product->id}}">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Write a review</h4>
				</div>
				<div class="modal-body">
					<div class="review-stars__container">
						<input type="radio" value="0" name="stars" id="star-null" />
						<input type="radio" value="1" name="stars" id="star-1" />
						<input type="radio" value="2" name="stars" id="star-2" />
						<input type="radio" value="3" name="stars" id="star-3" checked />
						<input type="radio" value="4" name="stars" id="star-4"  />
						<input type="radio" value="5" name="stars" id="star-5" />
						<section class="stars__container">
							<label for="star-1">
								<svg width="255" height="240" viewBox="0 0 51 48">
									<path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
								</svg>
							</label>
							<label for="star-2">
								<svg width="255" height="240" viewBox="0 0 51 48">
									<path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
								</svg>
							</label>
							<label for="star-3">
								<svg width="255" height="240" viewBox="0 0 51 48">
									<path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
								</svg>
							</label>
							<label for="star-4">
								<svg width="255" height="240" viewBox="0 0 51 48">
									<path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
								</svg>
							</label>
							<label for="star-5">
								<svg width="255" height="240" viewBox="0 0 51 48">
									<path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
								</svg>
							</label>
						</section>
					</div>
					<div class="form-group">
						<label for="writeyourreview">Write your review</label>
						<textarea class="form-control" rows="3" id="writeyourreview" name="review"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="uk-button uk-button-default" data-dismiss="modal">Close</button>
					<button type="submit" class="uk-button uk-button-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>