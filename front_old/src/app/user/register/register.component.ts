import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroup, FormBuilder, FormGroupDirective, NgForm, Validators} from '@angular/forms';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {

    constructor(private formBuilder: FormBuilder) {}

    registerForm: FormGroup;
    result: string;

    validateFormControl = new FormControl('', [
        Validators.required,
        Validators.email,
    ]);

    ngOnInit() {
        this.registerForm = this.formBuilder.group({
            name: '',
            cpf: ['', Validators.required],
            cellphone: ['', Validators.required],
            email: ['', Validators.required]

        });
    }

    save() {
        //let result;
        // this.user.cpf = this.registerForm.controls.cpf.value;
        // this.user.nome = this.registerForm.controls.nome.value;
        // this.user.telefone = this.registerForm.controls.telefone.value;
        // this.user.email = this.registerForm.controls.email.value;
    }

}
