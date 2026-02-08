<form method="POST" action="{{ $url }}" class="d-inline">
    @csrf
    <input type="hidden" name="is_enabled" value="{{ $model->is_enabled ? '0' : '1' }}">
    <div class="form-check form-switch mb-0">
        <input class="form-check-input" type="checkbox" role="switch"
               {{ $model->is_enabled ? 'checked' : '' }}
               onchange="this.form.querySelector('input[name=is_enabled]').value = this.checked ? '1' : '0'; this.form.submit();">
    </div>
</form>
