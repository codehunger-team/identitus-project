@extends('admin.base')

@section('section_title')
<strong>General Configuration</strong>
@endsection

@section('section_body')

<form method="POST" enctype="multipart/form-data">

<div class="row">
	<div class="col-xs-6">
	<dl>
		<dt>Enable Domain Logos?</dt>
		<dd>
			<input type="radio" name="enable_logos" value="No" @if('No' == App\Models\Option::get_option('enable_logos')) checked @endif> No
			<input type="radio" name="enable_logos" value="Yes" @if('Yes' == App\Models\Option::get_option('enable_logos')) checked @endif> Yes
		</dd>
		<dt>Enable Short Description?</dt>
		<dd>
			<input type="radio" name="enable_shortdesc" value="No" @if('No' == App\Models\Option::get_option('enable_shortdesc')) checked @endif> No
			<input type="radio" name="enable_shortdesc" value="Yes" @if('Yes' == App\Models\Option::get_option('enable_shortdesc')) checked @endif> Yes
		</dd>
		<dt>Enable Financing Form?</dt>
		<dd>
			<input type="radio" name="financingEnable" value="No" @if('No' == App\Models\Option::get_option('financingEnable')) checked @endif> No
			<input type="radio" name="financingEnable" value="Yes" @if('Yes' == App\Models\Option::get_option('financingEnable')) checked @endif> Yes
		</dd>
		<dt>Enable PayPal?</dt>
		<dd>
			<input type="radio" name="paypalEnable" value="No" @if('No' == App\Models\Option::get_option('paypalEnable')) checked @endif> No
			<input type="radio" name="paypalEnable" value="Yes" @if('Yes' == App\Models\Option::get_option('paypalEnable')) checked @endif> Yes
		</dd>
		<dt>Enable Stripe?</dt>
		<dd>
			<input type="radio" name="stripeEnable" value="No" @if('No' == App\Models\Option::get_option('stripeEnable')) checked @endif> No
			<input type="radio" name="stripeEnable" value="Yes" @if('Yes' == App\Models\Option::get_option('stripeEnable')) checked @endif> Yes
		</dd>
		<dt>Enable Escrow?</dt>
		<dd>
			<input type="radio" name="escrowEnable" value="No" @if('No' == App\Models\Option::get_option('escrowEnable')) checked @endif> No
			<input type="radio" name="escrowEnable" value="Yes" @if('Yes' == App\Models\Option::get_option('escrowEnable')) checked @endif> Yes
		</dd>
	</dl>
	</div>
	<div class="col-xs-6">
	<dl>
		<dt>Contact Email</dt>
		<dd>
			<input type="text" name="contact_email" value="{{ App\Models\Option::get_option('contact_email') }}" class="form-control">
		</dd>

		<dt>Admin Email</dt>
		<dd>
			<input type="text" name="admin_email" value="{{ App\Models\Option::get_option('admin_email') }}" class="form-control">
		</dd>

		<dt>Currency Symbol</dt>
		<dd>
			<input type="text" name="currency_symbol" value="{{ App\Models\Option::get_option('currency_symbol') }}" class="form-control">
		</dd>

		<dt>Currency ISO Code <small><a href="https://www.xe.com/iso4217.php" target="_blank">ISO List</a></dt>
		<dd>
			<input type="text" name="currency_code" value="{{ App\Models\Option::get_option('currency_code') }}" class="form-control">
		</dd>

	</dl>
	</div>
</div>
<div class="row">
	{!! csrf_field() !!}
	<div class="col-xs-12 col-md-6">
		<div class="box">
			<div class="box-body">
			<dl>
			<dt>SEO Title Tag</dt>
			<dd><input type="text" name="seo_title" value="{{ App\Models\Option::get_option('seo_title') }}" class="form-control"></dd>
			<dt>SEO Description Tag</dt>
			<dd><input type="text" name="seo_desc" value="{{ App\Models\Option::get_option('seo_desc') }}" class="form-control"></dd>
			<dt>SEO Keywords</dt>
			<dd><input type="text" name="seo_keys" value="{{ App\Models\Option::get_option('seo_keys') }}" class="form-control"></dd>
			<dt>Site Title (appears in navigation bar)</dt>
			<dd><input type="text" name="site_title" value="{{ App\Models\Option::get_option('site_title') }}" class="form-control"></dd>
			<dt>Homepage Header Image</dt>
			<dd><input type="file" name="homepage_header_image" class="form-control"></dd>
			<dt>Extra Javascript (added before closing {{ '<head>' }} tag. Ie. Analytics,etc.)</dt>
			<dd><textarea name="extra_js" class="form-control" rows="5">{{ App\Models\Option::get_option('extra_js') }}</textarea></dd>
			<td><h3>Header Icons</h3></td>
			<dt>Enable Phone Icon?</dt>
			<dd>
				<select name="phoneIcon">
					<option value="No">-Select-</option>
					<option value="No" @if('No' == App\Models\Option::get_option('phoneIcon')) selected @endif>No</option>
					<option value="Yes" @if('Yes' == App\Models\Option::get_option('phoneIcon')) selected @endif>Yes</option>
				</select>
			</dd>
			<dt>Enable Facebook Link</dt>
			<dd>
				<dd>
				<select name="fbIcon">
					<option value="No">-Select-</option>
					<option value="No" @if('No' == App\Models\Option::get_option('fbIcon')) selected @endif>No</option>
					<option value="Yes" @if('Yes' == App\Models\Option::get_option('fbIcon')) selected @endif>Yes</option>
				</select>
			</dd>
			</dd>
			<dt>Enable Twitter Link</dt>
			<dd>
				<select name="twIcon">
					<option value="No">-Select-</option>
					<option value="No" @if('No' == App\Models\Option::get_option('twIcon')) selected @endif>No</option>
					<option value="Yes" @if('Yes' == App\Models\Option::get_option('twIcon')) selected @endif>Yes</option>
				</select>
			</dd>
			<dt>Enable Linkedin Link</dt>
			<dd>
				<select name="linkedIcon">
					<option value="No">-Select-</option>
					<option value="No" @if('No' == App\Models\Option::get_option('linkedIcon')) selected @endif>No</option>
					<option value="Yes" @if('Yes' == App\Models\Option::get_option('linkedIcon')) selected @endif>Yes</option>
				</select>
			</dd>
			</dl>
			</div>
		</div>
	</div><!-- col-md<->xs -->

	<div class="col-xs-12 col-md-6">
		<div class="box">
			<div class="box-body">
			<dl>
				<dt>Homepage Headline</dt>
				<dd>
					<input type="text" name="homepage_headline" value="{{ App\Models\Option::get_option('homepage_headline') }}" class="form-control">
				</dd>
				<dt>Homepage Introductory Text</dt>
				<dd>
					<textarea name="homepage_intro" class="form-control" rows="5">{!! App\Models\Option::get_option('homepage_intro') !!}</textarea>
				</dd>
				<dt>Homepage About Us</dt>
				<dd>
					<textarea name="about_us" class="form-control" rows="9">{!! App\Models\Option::get_option('about_us') !!}</textarea>
				</dd>
				<dt>Phone Number</dt>
				<dd>
					<textarea name="phone_number" class="form-control" rows="1">{!! App\Models\Option::get_option('phone_number') !!}</textarea>
				</dd>
				<dt>Facebook Link</dt>
				<dd>
					<textarea name="facebook_follow_us" class="form-control" rows="1">{!! App\Models\Option::get_option('facebook_follow_us') !!}</textarea>
				</dd>
				<dt>Twitter Link</dt>
				<dd>
					<textarea name="twitter_follow_us" class="form-control" rows="1">{!! App\Models\Option::get_option('twitter_follow_us') !!}</textarea>
				</dd>
				<dt>Linkedin Link</dt>
				<dd>
					<textarea name="linkedin_follow_us" class="form-control" rows="1">{!! App\Models\Option::get_option('linkedin_follow_us') !!}</textarea>
				</dd>
			</dl>
			</div><!-- BODY FONT_COLOR -->
		</div>
	</div><!-- color setup -->

	{{-- Payment Configuration --}}
	<div class="col-xs-12 col-md-6">
		<div class="box">
			<div class="box-header with-border"><strong>Stripe Configurations</strong></div>
			<div class="box-body">

				<dt>Stripe Key</dt>
				<dd>
					<input type="text" name="stripe_key" value="{{ App\Models\Option::get_option('stripe_key') }}" class="form-control">
				</dd>

				<dt>Stripe Secret</dt>
				<dd>
					<input type="text" name="stripe_secret" class="form-control" value="{!! App\Models\Option::get_option('stripe_secret') !!}">
				</dd>
				<dt>Stripe Client ID</dt>
				<dd>
					<input type="text" name="stripe_client_id" class="form-control" value="{!! App\Models\Option::get_option('stripe_client_id') !!}">
				</dd>
			</div><!-- BODY FONT_COLOR -->
		</div>

		<div class="box">
			<div class="box-header with-border"><strong>Docusign Configurations</strong></div>
			<div class="box-body">

				<dt>Docusign Integration ID</dt>
				<dd>
					<input type="text" name="docusign_client_id" value="{{ App\Models\Option::get_option('docusign_client_id') }}" class="form-control">
				</dd>
			</dl>
			</div><!-- BODY FONT_COLOR -->
		</div>
	</div><!-- color setup -->

		{{-- Email Configuration --}}
		<div class="col-xs-12 col-md-6">
			<div class="box">
				<div class="box-header with-border"><strong>Email Configurations</strong></div>
				<div class="box-body">
				<dl>
					<dt>Mail Mailer</dt>
					<dd>
						<input type="text" name="mail_mailer" value="{{ App\Models\Option::get_option('mail_mailer') }}" class="form-control">
					</dd>
					<dt>Mail Host</dt>
					<dd>
						<input type="text" name="mail_host" class="form-control" value="{!! App\Models\Option::get_option('mail_host') !!}">
					</dd>
					<dt>Mail Port</dt>
					<dd>
						<input type="text" name="mail_port" class="form-control" value="{!! App\Models\Option::get_option('mail_port') !!}">
					</dd>
					<dt>Mail UserName</dt>
					<dd>
						<input type="text" name="mail_username" class="form-control" value="{!! App\Models\Option::get_option('mail_username') !!}">
					</dd>
					<dt>Mail Password</dt>
					<dd>
						<input type="text" name="mail_password" class="form-control" value="{!! App\Models\Option::get_option('mail_password') !!}">
					</dd>
					<dt>Mail Encryption </dt>
					<dd>
						<input type="text" name="mail_encryption" class="form-control" value="{!! App\Models\Option::get_option('mail_encryption') ?? null !!}">
					</dd>
				</dl>
				</div><!-- BODY FONT_COLOR -->
			</div>
		</div><!-- color setup -->


	<div class="col-xs-6">
		<input type="submit" name="sb_settings" value="Save" class="btn btn-block btn-primary">
	</div>

	</form>

</div><!-- ./row -->
@endsection

