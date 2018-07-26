import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroup, FormBuilder, FormGroupDirective, NgForm, Validators} from '@angular/forms';

import { UserService } from './../service/user.service';
import { User } from './user';

@Component({
	selector: 'app-user',
	templateUrl: './user.component.html',
	styleUrls: ['./user.component.scss']
})
export class UserComponent implements OnInit {

	constructor(private formBuilder: FormBuilder, private userService: UserService) {} 
	
	user: User = new User();
	registerForm: FormGroup;

	validateFormControl = new FormControl('', [
		Validators.required,
		Validators.email,
	]);

	ngOnInit() {
		this.registerForm = this.formBuilder.group({
			nome: '',
			cpf: ['', Validators.required],
			telefone: ['', Validators.required],
			email: ['', Validators.required]

		});
	}

	save() {
		let result;
		this.user.cpf = this.registerForm.controls.cpf.value;
		this.user.nome = this.registerForm.controls.nome.value;
		this.user.telefone = this.registerForm.controls.telefone.value;
		this.user.email = this.registerForm.controls.email.value;
		result = this.userService.addUser(this.user);
	}

}
