<form class="py-4" method="post" action="{{route('send.enquiry')}}">
   @csrf
    <div class="form-floating mb-3">
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="name"
               placeholder="Full Name" required>
        <label for="name">Full Name</label>
    </div>
    <div class="form-floating mb-3">
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" required>
        <label for="email">Email Address</label>
    </div>
    <div class="form-floating">
        <textarea class="form-control @error('contactMessage') is-invalid @enderror" placeholder="Leave a comment here" id="contactMessage" style="height: 100px" required></textarea>
        <label for="contactMessage" >Comments</label>
    </div>
   <button type="submit" class="btn btn-warning my-2 float-end">Submit</button>
</form>
