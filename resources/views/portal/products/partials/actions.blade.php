<a href="{{ route('dashboard.products.edit',$product->id) }}"
   class="btn btn-sm btn-warning">
    Edit
</a>

<form action="{{ route('dashboard.products.destroy',$product->id) }}"
      method="POST"
      class="d-inline">
    @csrf
    @method('DELETE')

    <button class="btn btn-sm btn-danger"
            onclick="return confirm('Delete?')">
        Delete
    </button>
</form>
