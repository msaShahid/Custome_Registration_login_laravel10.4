@extends('../layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">API</div>
        </div>
    </div>    
</div>

<div class="row">
  <div class="card-body">
      <table class="table table-strip">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>tilte</th>
                  <th>body</th>
              </tr>
          </thead>
          <tbody>
              @forelse($postList as $apiPD)
                  <tr>
                      <td>{{ $apiPD->id }}</td>
                      <td>{{ $apiPD->title }}</td>
                      <td>{{ $apiPD->body }}</td>
                  </tr>
              @empty
              <tr>
                  <td colspan="5">No Data Found</td>
              </tr>
              @endforelse
          </tbody>
      </table>
  </div>
</div>
    
@endsection