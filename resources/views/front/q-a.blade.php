@extends('layouts.app')
@section('seo')
<link rel="canonical" href="{{url('q-and-a')}}" />
@endsection
@section('content')
    <div class="container">
        <div class="row mt-6">
            <div class="col-sm-12">
                <h1 class="text-theme text-center">Questions &amp; Answers</h1>
                <div class="separator-3"></div>
                <hr>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-lg-8 col-sm-12 mx-auto">
                <div class="accordion accordion-flush" id="accordionFlushOne">
                    {{--                    One--}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                What happens when the lease contract ends?
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                             aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>First and foremost, at Identitius you can buy the domain so that you have full control before the lease ends.</p>
                                <p>If you do not execute your right to buy the domain during, then you can still negotiate with the domain owner / lessor to renew the lease.</p>
                                <p>Lastly, if you or the domain owner / lessor chooses not to renew, then the domain owner / lessor will re-assume DNS control. You do not lose your site, but they will likely no longer point the domain to your site.</p>
                                <p><b>A domain lease is very similar to a commercial real estate lease, except here we give you the option to buy.</b></p>
                            </div>
                        </div>
                    </div>
                    {{--                    Two--}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo">
                                Can I buy the domain?
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                             aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>Yep, every domain listed on Identitius includes an option to buy
                                    up front or during the lease period. The expiration on the purchase option typically
                                    ends when the lease period ends, but it may end sooner or extend further, depending
                                    upon the contract.</p>
                            </div>
                        </div>
                    </div>
                    {{--                    Three--}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseThree" aria-expanded="false"
                                    aria-controls="flush-collapseThree">
                                How do trademarks, copyrights, or other IP infringements work when leasing a domain?
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                             aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>Identitius asks all domain owners to attest that their
                                    domains are free of any trademark, copyright, or other IP infringements. Identitius
                                    makes no guarantees in this regard as trademark issues are between the domain owner
                                    and the party leasing the domain.</p>
                                <p>Conversely, domain owners / lessors may include copyright or trademark rights. Again, check with the owner as
                                    Identitius makes no guarantees as these issues are between the domain owners and the
                                    party leasing the domain.</p>
                                <p>It’s always smart to consult with an attorney as well.</p>
                            </div>
                        </div>
                    </div>
                    {{--                    Four--}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseFour" aria-expanded="false"
                                    aria-controls="flush-collapseFour">
                                If the domain I’m leasing was used for another website before, how do I handle that
                                traffic? How does this impact SEO?
                            </button>
                        </h2>
                        <div id="flush-collapseFour" class="accordion-collapse collapse"
                             aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>Free traffic is usually a good thing. We’ll leave it up to
                                    you how you want to handle traffic who’s looking for the prior tenant.</p>

                                <p>With SEO, you should be in a better position than just starting from scratch, unless
                                    the prior tenant “damaged” the property. SEO principles apply the same here as
                                    anywhere, so due diligence on your end matters.</p>
                            </div>
                        </div>
                    </div>
                    {{--                    Five--}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseFive" aria-expanded="false"
                                    aria-controls="flush-collapseFive">
                                What happens if I decide to use another domain after putting work into the site?
                            </button>
                        </h2>
                        <div id="flush-collapseFive" class="accordion-collapse collapse"
                             aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>Your site is yours. You can move your site where you want, let your customers and search engines know, and ask
                                    websites with backlinks to your site to make changes. Ultimately, the site is yours and the domain is not. Unless, of course, you choose to buy it.</p>
                            </div>
                        </div>
                    </div>
                    {{--                    Six--}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingSix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseSix" aria-expanded="false"
                                    aria-controls="flush-collapseSix">
                                I want to offer my domains for lease on Identitius. What do I do?
                            </button>
                        </h2>
                        <div id="flush-collapseSix" class="accordion-collapse collapse"
                             aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>We welcome lonely domains! Please contact us using the form in the footer below.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
