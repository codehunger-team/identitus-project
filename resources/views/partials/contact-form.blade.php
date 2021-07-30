<form class="py-4" method="post" action="{{route('send.enquiry')}}">
    @csrf
    <div class="form-group">
        <label for="name">Name <span class="text-danger">*</span></label>
        <input type="name" name="name" class="form-control  @error('name') is-invalid @enderror" required id="name" aria-describedby="name"
            placeholder="Enter Name">
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="email">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control  @error('email') is-invalid @enderror" required id="email" aria-describedby="email"
            placeholder="Enter email">
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="message" class="form-label">Your Message <span class="text-danger">*</span></label>
        <textarea class="form-control" name="message  @error('message') is-invalid @enderror" required id="exampleFormControlTextarea1"
            placeholder="I want to know ..." rows="3"></textarea>
        @error('message')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <button type="submit" class="btn btn-warning my-2 float-end">Submit</button>
</form>