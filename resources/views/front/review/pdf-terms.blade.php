@auth
<div class="container" id="contract">
    <br />
    <br />
    <br />

    <h1 class="text-center display-5">
        Domain name lease and option to purchase
        <b>{{$domainName ?? ''}}</b>
    </h1>
    <br />
   
    <p>THIS LEASE AGREEMENT (the “Agreement”) for the Domain Name, <b>{{$domainName ?? ''}}</b>, beginning at the date
        and time of <b>{{changeDateFormat($getCurrentDateTime) ?? ''}} UTC</b> is between <b>{{$lessor->company ?? ''}}</b> of
        <b>{{ $lessor->street_1 .', '. $lessor->street_2 }}{{$lessor->city . ', ' .$lessor->state . ', ' .$lessor->zip . ', ' .$lessor->country ?? '' }}</b>,
        the Domain Owner (the “Lessor”), and <b>{{ Auth::user()->company ?? Auth::user()->name }}</b>, of
        <b>{{ Auth::user()->street_1 ?? '' }}</b>,
        @isset(Auth::user()->street_2) <b>{{ Auth::user()->street_2 ?? ''}}, @endisset
            {{Auth::user()->city ?? ''}}, {{Auth::user()->state ?? ''}}, {{Auth::user()->country ?? ''}}, {{Auth::user()->zip ?? ''}}</b>, the party
        wishing to obtain the use of the Domain Name (the “Lessee”).</p>

    <p><b>THE LESSOR AND THE LESSEE HEREBY AGREE as follows:</b></p>

    <p><b>1. Lease</b></p>
    <p>The Lessor shall lease to the Lessee, and the Lessee shall lease from the Lessor, the domain name identified as,
        <b>{{$domainName ?? ''}}</b>, (“the Domain Name”) on the terms and conditions contained in this Lease.</p>

    <p><b>2. Term and Use of the Domain Name</b></p>

    <p>Subject to receipt of the First Payment, as defined below in Paragraph 3 and subject to Paragraph 4, the term
        (the “Term”) of this Lease shall be for a time length of <b>{{$contracts->number_of_periods ?? ''}}</b>
        <b>{{$periodType}}</b>s, commencing on <b>{{changeDateFormat($getCurrentDateTime) ?? ''}} UTC</b> (the “Effective Date and Time”) and
        expiring <b>{{$contracts->number_of_periods ?? ''}}</b> <b>{{$periodType}}</b>s thereafter, specifically at
        <b>{{changeDateFormat($endOfLease) ?? ''}}</b> (the “Expiration Date and Time”).
        Throughout the Term, so long as the Lessee’s obligations under this Agreement are in good standing, the Lessee
        shall have the right to use the Domain Name in accordance with the terms and conditions contained herein.

        Upon Expiry of the Term, this Lease Agreement shall be immediately terminated, except for the indemnification
        provisions arising out of the Lessee’s use of the Domain Name, as set out at Paragraph 8, below, which shall
        survive the termination of this Agreement, and subject to the option to purchase.</p>

    <p><b>3. Payments</b></p>
    <p>The Lessee shall pay to the Lessor, the first non-refundable payment, in the amount of US
        $<b>{{$contracts->first_payment ?? ''}}</b> (the “Set-Up Payment”) due immediately.</p>

    <p>On the <b>{{$getCurrentDayOfMonth ?? ''}}</b> of each successive <b>{{$periodType}}</b> of the
        <b>{{$contracts->number_of_periods ?? ''}}</b>-<b>{{$periodType}}</b> Term, commencing on
        <b>{{changeDateFormat($getCurrentDateTime) ?? ''}} UTC</b>, the Lessee shall pay to the Lessor a <b>{{$periodType}}ly</b> rental price
        of US $<b>{{$contracts->period_payment ?? ''}}</b>, for the use of Domain Name, inclusive of all applicable taxes
        and transaction fees, and without any deduction or set-off (“Rent”).</p>

    <p>The Set-up Payment and Rent are collectively referred to herein as “Payments”. </p>


    <p><b>4. Option to Purchase</b></p>
    <p>Provided that the Lessee’s obligations hereunder are in good standing, at any time during the Term and up to the
        moment <b>{{$o->option_expiration ?? ''}}</b>, the Lessee may notify the Lessor in writing that it intends to exercise
        its option (the “Option”) to purchase the Domain Name by paying all of the remaining Rent otherwise payable
        through until the end of the Term, plus the sum of US $<b>{{$contracts->option_price ?? ''}}</b> (the “Option
        Purchase Price”).</p>

    <p>As a condition of the Option, the Option Purchase Price must be paid no later than ten (10) days subsequent to
        the notice of exercise of the Option, and shall be paid to the Lessor via Wire Transfer or as otherwise
        instructed by the Lessor.</p>

    <p>Upon payment of the Option Purchase Price as aforesaid, the Domain Name shall be transferred to the Lessee and
        this Lease Agreement shall thereafter be immediately terminated, except for the indemnification provisions
        arising out of the Lessee’s use of the Domain Name, at Paragraph 8, below, which shall survive the termination
        of this Agreement.</p>

    <p><b>5. Method of Payment</b></p>
    <p>The Lessee shall pay the Set-up Payment and Rent via credit or debit card through the Identitius website. The
        Lessee shall make all Rent payments to the Lessor through the Identitius website unless otherwise instructed by
        the Lessor. The Option Purchase Price shall be paid via wire transfer, or as instructed by the Lessor.</p>

    <p><b>6. Ownership of Domain Name</b></p>
    <p>(a) The Lessor retains full title to the Domain Name notwithstanding the Lease of the same to the Lessee subject
        only to the right only to use the Domain Name in accordance with the terms of this Lease, and subject to any
        valid exercise of the Option.</p>
    <p>(b) The Domain Name shall remain registered to the Lessor throughout the Term of this Lease. The Lessee shall be
        entitled to direct Identitius and/or the Lessor to set the DNS settings for the Domain Name from time to time by
        providing those instructions using the Identitius website.</p>
    <p>(c) Lessee acknowledges that no option provided or representation, either express or implied, written or oral has
        been made by or on behalf of the Lessor to the Lessee that the Domain Name may be purchased from the Lessor by
        the Lessee or by any nominee of the Lessee at any time, except in strict accordance with the terms of the
        Option, as set out above.</p>

    <p><b>7. Lessee’s Compliance</b></p>
    <p>The Lessee, in its use of the Domain Name, shall comply with all applicable laws whether local, state,
        provincial, federal, national, international or interplanetary, which apply to the use by the Lessee of the
        Domain Name. The Lessee shall use the Domain Name only for a website and associated email related to the
        business of person or company name. The Lessee shall promptly notify the Lessor and Identitius of any claim,
        demand, threat, or legal proceeding, arising in any way from the Lessee’s use of the Domain Name or the Lessor’s
        registration of the Domain Name. The Lessor retains the right to terminate this Lease Agreement immediately and
        without notice, if the Lessee uses the Domain Name in any manner is not in compliance with any laws or
        regulations, subject to the Lessee’s right to cure any such misconduct if such cure is curable.</p>

    <p><b>8. Indemnity</b></p>
    <p>The Lessee shall indemnify and save harmless the Lessor against all damages, losses or liabilities which may
        arise in respect of the Lessee’s use and operation of the Domain Name.</p>

    <p><b>9. Default</b></p>
    <p>(a) The Lessor and the Lessee agree that each of the following events amounts to a default by the Lessee under
        this Lease:
        <li>If the Lessee fails to pay any Payment payable under this Lease on the due date for payment, subject to a
           {{$gracePeriod}} day grace period; </li>
        <li> the Lessee fails to perform or observe any of the covenants or provisions of this Lease on the part of
            the Lessee to be performed or observed; </li>
        <li>If a writ of execution is issued against the Lessee’s property under a judgment in any court of
            competent jurisdiction; </li>
        <li>If a distress warrant is issued against the Lessee’s property under a judgment in any court of
            competent jurisdiction; </li>
        <li>If the Lessee becomes bankrupt or if the Lessee makes an assignment or composition with the Lessee’s
            creditors or if the Lessee is a body corporate and a resolution is passed or a petition filed for the
            winding up of the Lessee other than for the purposes of reconstruction or amalgamation or if the Lessee
            becomes subject to the appointment of a receiver. </li>
    </p>

    <p>(b) In the event default occurs, the Lessor and/or Identitius may immediately or at any time thereafter reset the
        DNS setting for the Domain Name and terminate this Lease Agreement, without giving any notice to the Lessee and
        without releasing the Lessee from any liability in respect of any breach or non-observance of any of the
        provisions contained or implied in this Lease, and without prejudice to the Lessor’s right to retain all money
        paid to the Lessor pursuant to this Lease and the Lessor’s right to claim damages pursuant to subparagraph (c)
        below.</p>

    <p>(c) If this Lease is terminated for any reason other than its due fulfillment by the Lessee, or other than as a
        result of Early Termination, or other than with the express consent of the Lessor in writing, then without
        prejudice to its other rights at law or in equity the Lessor may at any time demand immediate payment of all of
        the following: </br>
        (i) All arrears of Rent and other money then due and/or payable by the Lessee under the Lease. </br>
        (ii) The Lessor’s loss on the Lease to be notified by the Lessor to the Lessee. </br>
        (iii) All costs and expenses incurred by the Lessor enforcing this agreement. </br>
        (iv) Interest on all money payable under this provision from the date of termination, the date of payment at
            the rate of 3% per year calculated monthly.</br>
    </p>

    <p><b>10. Invalidity or Severability</b></p>

    <p>If any Article, Section, paragraph or provision of this Agreement is determined to be void or unenforceable in
        whole or in part, it shall not affect or impair the validity or enforcement of any other provision of this
        Agreement. Any provisions of this Agreement which are or may be rendered invalid, unenforceable or illegal,
        shall be ineffective only to the extent of such invalidity, unenforceability or illegality, without affecting
        the validity, enforceability or legality of the remaining provisions of this Agreement, it being the intent and
        purpose that this Agreement should survive and be valid to the maximum extent permitted by applicable law. For
        greater certainty, this Agreement shall be read as if the invalid, unenforceable or illegal provision had never
        formed part hereof, and a “provision” for these purposes shall include the smallest severable portion of
        sections, paragraphs or clauses, or sentences contained therein, and not, unless the context absolutely
        requires, the whole thereof.</p>

    <p><b>11. Waiver</b></p>
    <p>No party to this Agreement shall be deemed to have waived any of its rights, powers or remedies under this
        Agreement unless such waiver is expressly set forth in writing. No consent or waiver, express or implied, by a
        party of any breach or default by the other party in the performance of such other party of its obligations
        shall be deemed or construed to be a consent or waiver to or of any other breach or default in the performance
        by such other party of the same or any other obligations under this Agreement of such other party. Failure on
        the part of a party to complain of any act or failure to act of another party or to declare another party in
        default, irrespective of how long such failure continues, shall not constitute a waiver by the first mentioned
        party of its rights under this Agreement.</p>


    <p><b>12. Timestamp</b></p>
    <p>This Agreement shall use UTC timestamps for all Dates and Times, including, but not limited to the Effective Date
        and Time, Expiration Date and Time, Option Expiration Date and Time, payment due dates, and grace periods.</p>

    <p><b>13. Governing Law</b></p>
    <p>This Agreement shall be governed by and construed in accordance with the laws of the State of Arizona within the
        United States and the parties hereby exclusively attorn to the jurisdiction of the courts of Pima County,
        Arizona, United States.
        <!--<b>{{Auth::user()->state  . ', ' .Auth::user()->country ?? '' }}</b> and the parties hereby exclusively attorn to the jurisdiction of the courts of <b>{{Auth::user()->city . ', ' .Auth::user()->state  . ', ' .Auth::user()->country ?? '' }}</b>.</p>-->

        <p><b>14. Notices</b></p>
        <p>All notices required or permitted to be given pursuant to this Agreement shall be delivered by notification
            through Identitius or sent by electronic email or other form of transmitted or electronic message or sent by
            prepaid courier directly to such party at the following addresses, respectively;</p>

        <p>If to Lessee:</p>

        <p><b>{{Auth::user()->company ?? ''}}</b>
            <br>{{ Auth::user()->street_1 .', '. Auth::user()->street_2 }}
            <br>{{Auth::user()->city . ', ' .Auth::user()->state . ',' .Auth::user()->zip ?? '' }}
            <br>{{Auth::user()->country ?? '' }}
            <br>{{Auth::user()->email ?? ''}}
            <br>{{Auth::user()->phone ?? ''}}</p>


        <p>If to Lessor:</p>

        @if(!$lessor)
        <p><b>Identitius</b>
            <br>30 N Gould Street, Suite R
            <br>Sheridan, WY 82801
            <br>United States of Amercia
            <br>info@identitius.com
            <br>520-461-7061</p>
        @else
        <p><b>{{$lessor->company ?? ''}}</b>
            <br>{{ $lessor->street_1 .', '. $lessor->street_2 }}
            <br>{{$lessor->city . ', ' .$lessor->state . ',' .$lessor->zip ?? '' }}
            <br>{{$lessor->country ?? '' }}
            <br>{{$lessor->email ?? ''}}
            <br>{{$lessor->phone ?? ''}}</p>
        @endif



        <p>or at such other address as either party may stipulate by notice to the other. Any notice delivered by hand
            or prepaid courier or sent by facsimile or electronic email shall be deemed to be received on the date of
            actual delivery thereof. Any notice so sent by telex, telegram or similar form of transmitted message shall
            be deemed to have been received on the next day following transmission.</p>

        <p>IN WITNESS WHEREOF the parties hereto have executed this Agreement on the date first above written.</p>
         
        @if(str_contains(url()->current(), '/review-terms'))
            <p>[LESSEE]</p>
            <p>Name:{{Auth::user()->name ?? ''}} </p>
            {{-- <p>Created At: December 06, 2023 07:19 pm</p> --}}
            {{-- <p>IP: {{Request::ip() ?? ''}}</p> --}}
            
            ===================================================================== 
        @endif
        <p>[LESSOR]</p>
        <p>Name:{{$lessor->name ?? ''}} </p>
        {{-- <p>Created At: {{changeDateFormat($lessor->created_at)}}</p>
        <p>IP: {{$lessor->ip ?? Request::ip()}}</p> --}}

</div>
@endauth