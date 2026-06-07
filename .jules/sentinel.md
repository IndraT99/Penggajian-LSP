## 2024-05-24 - Mass Assignment Vulnerability in Controllers
**Vulnerability:** Found `DivisiController` and `JabatanController` using `$request->all()` to populate model creations and updates directly after validation, exposing the models to mass assignment attacks.
**Learning:** Even when `validate` is called prior, using `$request->all()` passes all user-provided input to the model. This allows attackers to modify fields that are not present in the validation rules if those fields are fillable.
**Prevention:** Always use the array returned by `$request->validate()` (or `$request->validated()` for Form Requests) when creating or updating models to ensure only explicitly allowed and validated fields are processed.
