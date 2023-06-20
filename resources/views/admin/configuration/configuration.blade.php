@extends('admin.base')

@section('section_title')
    <strong>General Configuration</strong>
@endsection

@section('section_body')
    <form method="POST" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="card border-0 p-3 shadow my-3">
            <div class="card-header border-0 bg-white mb-3">
                <h4 class="text-muted"> Basic Setting</h4>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <dl>
                        <dt>Enable Domain Logos?</dt>
                        <dd>
                            <input type="radio" name="enable_logos" value="No" <?php if ('No' == App\Models\Option::get_option('enable_logos')) : ?> checked
                                <?php endif; ?>> No
                            <input type="radio" name="enable_logos" value="Yes" <?php if ('Yes' == App\Models\Option::get_option('enable_logos')) : ?> checked
                                <?php endif; ?>> Yes
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Enable Short Description?</dt>
                        <dd>
                            <input type="radio" name="enable_shortdesc" value="No" <?php if ('No' == App\Models\Option::get_option('enable_shortdesc')) : ?> checked
                                <?php endif; ?>> No
                            <input type="radio" name="enable_shortdesc" value="Yes" <?php if ('Yes' == App\Models\Option::get_option('enable_shortdesc')) : ?> checked
                                <?php endif; ?>> Yes
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Enable Financing Form?</dt>
                        <dd>
                            <input type="radio" name="financingEnable" value="No" <?php if ('No' == App\Models\Option::get_option('financingEnable')) : ?> checked
                                <?php endif; ?>> No
                            <input type="radio" name="financingEnable" value="Yes" <?php if ('Yes' == App\Models\Option::get_option('financingEnable')) : ?> checked
                                <?php endif; ?>> Yes
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Enable PayPal?</dt>
                        <dd>
                            <input type="radio" name="paypalEnable" value="No" <?php if ('No' == App\Models\Option::get_option('paypalEnable')) : ?> checked
                                <?php endif; ?>> No
                            <input type="radio" name="paypalEnable" value="Yes" <?php if ('Yes' == App\Models\Option::get_option('paypalEnable')) : ?> checked
                                <?php endif; ?>> Yes
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Enable Stripe?</dt>
                        <dd>
                            <input type="radio" name="stripeEnable" value="No" <?php if ('No' == App\Models\Option::get_option('stripeEnable')) : ?> checked
                                <?php endif; ?>> No
                            <input type="radio" name="stripeEnable" value="Yes" <?php if ('Yes' == App\Models\Option::get_option('stripeEnable')) : ?> checked
                                <?php endif; ?>> Yes
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Enable Escrow?</dt>
                        <dd>
                            <input type="radio" name="escrowEnable" value="No" <?php if ('No' == App\Models\Option::get_option('escrowEnable')) : ?> checked
                                <?php endif; ?>> No
                            <input type="radio" name="escrowEnable" value="Yes" <?php if ('Yes' == App\Models\Option::get_option('escrowEnable')) : ?> checked
                                <?php endif; ?>> Yes
                        </dd>
                    </dl>
                </div>

            </div>
        </div>

        <div class="card border-0 p-3 shadow my-3">
            <div class="card-header border-0 bg-white mb-3">
                <h4 class="text-muted">Contact Setting</h4>
            </div>

            <div class="row">

                <div class="col-md-6">
                    <dl>
                        <dt>Contact Email</dt>
                        <dd>
                            <input type="text" name="contact_email" value="<?php echo e(App\Models\Option::get_option('contact_email')); ?>" class="form-control">
                        </dd>

                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Admin Email</dt>
                        <dd>
                            <input type="text" name="admin_email" value="<?php echo e(App\Models\Option::get_option('admin_email')); ?>" class="form-control">
                        </dd>

                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Currency Symbol</dt>
                        <dd>
                            <input type="text" name="currency_symbol" value="<?php echo e(App\Models\Option::get_option('currency_symbol')); ?>" class="form-control">
                        </dd>

                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Currency ISO Code <small><a href="https://www.xe.com/iso4217.php" target="_blank">ISO List</a>
                        </dt>
                        <dd>
                            <input type="text" name="currency_code" value="<?php echo e(App\Models\Option::get_option('currency_code')); ?>" class="form-control">
                        </dd>

                    </dl>
                </div>

            </div>
        </div>

        <div class="card border-0 p-3 shadow my-3">
            <div class="card-header border-0 bg-white mb-3">
                <h4 class="text-muted">SEO Setting</h4>
            </div>

            <div class="row">

                <div class="col-md-6">
                    <dl>
                        <dt>SEO Title Tag</dt>
                        <dd>
                            <input type="text" name="seo_title" value="{{ App\Models\Option::get_option('seo_title') }}"
                                class="form-control">
                        </dd>

                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>SEO Description Tag</dt>
                        <dd>
                            <input type="text" name="seo_desc" value="{{ App\Models\Option::get_option('seo_desc') }}"
                                class="form-control">
                        </dd>

                    </dl>
                </div>

                <dl>
                    <dt>SEO Keywords</dt>
                    <dd>
                        <input type="text" name="seo_keys" value="{{ App\Models\Option::get_option('seo_keys') }}"
                            class="form-control">
                    </dd>

                </dl>
            </div>
        </div>


        <div class="card border-0 p-3 shadow my-3">
            <div class="card-header border-0 bg-white mb-3">
                <h4 class="text-muted">Site Setting</h4>
            </div>

            <div class="row">

                <div class="col-md-6">
                    <dl>
                        <dt>Site Title (appears in navigation bar)</dt>
                        <dd>
                            <input type="text" name="site_title"
                                value="{{ App\Models\Option::get_option('site_title') }}" class="form-control">
                        </dd>

                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Homepage Header Image</dt>
                        <dd>
                            <input type="file" name="homepage_header_image" class="form-control">
                        </dd>

                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Extra Javascript (added before closing {{ '<head>' }} tag. Ie. Analytics,etc.)</dt>
                        <dd>
                            <textarea name="extra_js" class="form-control" rows="5">{{ App\Models\Option::get_option('extra_js') }}</textarea>
                        </dd>

                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Homepage Headline</dt>
                        <dd>
                            <input type="text" name="homepage_headline"
                                value="{{ App\Models\Option::get_option('homepage_headline') }}" class="form-control">
                        </dd>

                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Homepage Introductory Text</dt>
                        <dd>
                            <textarea name="homepage_intro" class="form-control" rows="5">{!! App\Models\Option::get_option('homepage_intro') !!}</textarea>
                        </dd>

                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Homepage About Us</dt>
                        <dd>
                            <textarea name="about_us" class="form-control" rows="9">{!! App\Models\Option::get_option('about_us') !!}</textarea>
                        </dd>

                    </dl>
                </div>

            </div>

        </div>


        <div class="card border-0 p-3 shadow my-3">
            <div class="card-header border-0 bg-white mb-3">
                <h4 class="text-muted">Header Icon Setting</h4>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <dl>
                        <dt>Enable Phone Icon?</dt>
                        <dd>
                            <select name="phoneIcon">
                                <option value="No">-Select-</option>
                                <option value="No" @if ('No' == App\Models\Option::get_option('phoneIcon')) selected @endif>No</option>
                                <option value="Yes" @if ('Yes' == App\Models\Option::get_option('phoneIcon')) selected @endif>Yes</option>
                            </select>
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Enable Facebook Link</dt>
                        <dd>
                            <select name="fbIcon">
                                <option value="No">-Select-</option>
                                <option value="No" @if ('No' == App\Models\Option::get_option('fbIcon')) selected @endif>No</option>
                                <option value="Yes" @if ('Yes' == App\Models\Option::get_option('fbIcon')) selected @endif>Yes</option>
                            </select>
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Enable Twitter Link</dt>
                        <dd>
                            <select name="twIcon">
                                <option value="No">-Select-</option>
                                <option value="No" @if ('No' == App\Models\Option::get_option('twIcon')) selected @endif>No</option>
                                <option value="Yes" @if ('Yes' == App\Models\Option::get_option('twIcon')) selected @endif>Yes</option>
                            </select>
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Enable Linkedin Link</dt>
                        <dd>
                            <select name="linkedIcon">
                                <option value="No">-Select-</option>
                                <option value="No" @if ('No' == App\Models\Option::get_option('linkedIcon')) selected @endif>No</option>
                                <option value="Yes" @if ('Yes' == App\Models\Option::get_option('linkedIcon')) selected @endif>Yes</option>
                            </select>
                        </dd>
                    </dl>
                </div>

            </div>
        </div>

        <div class="card border-0 p-3 shadow my-3">
            <div class="card-header border-0 bg-white mb-3">
                <h4 class="text-muted">Social Media Setting</h4>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <dl>
                        <dt>Phone Number</dt>
                        <dd>
                            <textarea name="phone_number" class="form-control" rows="1">{!! App\Models\Option::get_option('phone_number') !!}</textarea>
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Facebook Link</dt>
                        <dd>
                            <textarea name="facebook_follow_us" class="form-control" rows="1">{!! App\Models\Option::get_option('facebook_follow_us') !!}</textarea>
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Twitter Link</dt>
                        <dd>
                            <textarea name="twitter_follow_us" class="form-control" rows="1">{!! App\Models\Option::get_option('twitter_follow_us') !!}</textarea>
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Linkedin Link</dt>
                        <dd>
                            <textarea name="linkedin_follow_us" class="form-control" rows="1">{!! App\Models\Option::get_option('linkedin_follow_us') !!}</textarea>
                        </dd>
                    </dl>
                </div>

            </div>
        </div>

        <div class="card border-0 p-3 shadow my-3">
            <div class="card-header border-0 bg-white mb-3">
                <h4 class="text-muted">Email Setting</h4>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <dl>
                        <dt>Mail Mailer</dt>
                        <dd>
                            <input type="text" name="mail_mailer"
                                value="{{ App\Models\Option::get_option('mail_mailer') }}" class="form-control">
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Mail Host</dt>
                        <dd>
                            <input type="text" name="mail_host" class="form-control" value="{!! App\Models\Option::get_option('mail_host') !!}">
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Mail Port</dt>
                        <dd>
                            <input type="text" name="mail_port" class="form-control" value="{!! App\Models\Option::get_option('mail_port') !!}">
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Mail UserName</dt>
                        <dd>
                            <input type="text" name="mail_username" class="form-control"
                                value="{!! App\Models\Option::get_option('mail_username') !!}">
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Mail Password</dt>
                        <dd>
                            <input type="text" name="mail_password" class="form-control"
                                value="{!! App\Models\Option::get_option('mail_password') !!}">
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Mail Encryption</dt>
                        <dd>
                            <input type="text" name="mail_encryption" class="form-control"
                                value="{!! App\Models\Option::get_option('mail_encryption') ?? null !!}">
                        </dd>
                    </dl>
                </div>

            </div>
        </div>

        <div class="card border-0 p-3 shadow my-3">
            <div class="card-header border-0 bg-white mb-3">
                <h4 class="text-muted">DOCUSIGN Setting</h4>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <dl>
                        <dt>Docusign Base URL</dt>
                        <dd>
                            <textarea name="docusign_base_url" class="form-control" rows="1">{!! App\Models\Option::get_option('docusign_base_url') !!}</textarea>
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Docusign Account ID</dt>
                        <dd>
                            <textarea name="docusign_account_id" class="form-control" rows="1">{!! App\Models\Option::get_option('docusign_account_id') !!}</textarea>

                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Docusign Client ID</dt>
                        <dd>
                            <textarea name="docusign_client_id" class="form-control" rows="1">{!! App\Models\Option::get_option('docusign_client_id') !!}</textarea>

                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl>
                        <dt>Docusign Client Secret</dt>
                        <dd>
                            <textarea name="docusign_client_secret" class="form-control" rows="1">{!! App\Models\Option::get_option('docusign_client_secret') !!}</textarea>
                        </dd>
                    </dl>
                </div>

            </div>
        </div>



        <!-- col-md<->xs -->

        <!-- color setup -->

        {{-- Payment Configuration --}}
        <div class="col-xs-12 col-md-6">
            {{-- <div class="box">
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
		</div> --}}

            {{-- <div class="box">
			<div class="box-header with-border"><strong>Docusign Configurations</strong></div>
			<div class="box-body">

				<dt>Docusign Integration ID</dt>
				<dd>
					<input type="text" name="docusign_client_id" value="{{ App\Models\Option::get_option('docusign_client_id') }}" class="form-control">
				</dd>
			</dl>
			</div><!-- BODY FONT_COLOR -->
		</div> --}}
        </div><!-- color setup -->

        {{-- Email Configuration --}}
        <!-- color setup -->


        <div class="col-xs-6">
            <input type="submit" name="sb_settings" value="Save" class="btn btn-block btn-primary">
        </div>

    </form>

    </div><!-- ./row -->
@endsection
