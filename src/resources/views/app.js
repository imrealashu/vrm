class ValidationErrors {
    constructor() {
        this.errors = {};
    }

    has() {
        return this.errors.hasOwnProperty;
    }

    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }

    record(errors) {
        this.errors = errors;
    }

    clear(field) {
        delete this.errors[field];
    }
}