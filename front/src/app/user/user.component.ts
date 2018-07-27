import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroup, FormBuilder, FormGroupDirective, NgForm, Validators} from '@angular/forms';

import { UserService } from './../service/user.service';
import { User } from './user';

@Component({
	selector: 'app-user',
	templateUrl: './user.component.html',
	styleUrls: ['./user.component.scss'],
	providers: [UserService]
})
export class UserComponent implements OnInit {

	constructor(private formBuilder: FormBuilder, private userService: UserService) {} 
	
	user: User = new User();
	registerForm: FormGroup;
	result: string;

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
		//let result;
		this.user.cpf = this.registerForm.controls.cpf.value;
		this.user.nome = this.registerForm.controls.nome.value;
		this.user.telefone = this.registerForm.controls.telefone.value;
		this.user.email = this.registerForm.controls.email.value;
		
		
		this.userService.addUser(this.user).subscribe(data => this.result = JSON.stringify(data),
							error => alert(error),
						() => console.log('acesso a webapi post ok')
					);
		console.log('Resultado: ' + this.result);		
		
		//this.result = this.userService.addUser(this.user);
	}

}
