import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import {FormControl, FormGroup, FormBuilder, FormGroupDirective, NgForm, Validators} from "@angular/forms";
import {RegisterService} from "./register.service";


@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  encapsulation: ViewEncapsulation.None,
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {

    constructor(private formBuilder: FormBuilder, private registerService: RegisterService) {}

    registerForm: FormGroup;
    result: string;
    hide:boolean = true;

    validateFormControl = new FormControl('', [
        Validators.required,
        Validators.email,
    ]);

    ngOnInit() {
        this.registerForm = this.formBuilder.group({
            name: '',
            cpf: ['', Validators.required],
            cellphone: ['', Validators.required],
            email: ['', [Validators.required, Validators.email]],
            password: ['', Validators.required]
        });
    }

    get f() { return this.registerForm.controls; }

    save() {
        let formValues = this.registerForm.getRawValue();
        this.registerService.register(formValues).add(result => {});

    }

    getErrorMessage() {
        return this.f.email.hasError('required') ? 'O e-mail é obrigatório.' :
            this.f.email.hasError('email') ? 'E-mail inválido.' : '';
    }



}
