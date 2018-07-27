import { FormBuilder, FormGroup, FormControl, Validators } from '@angular/forms';
import { Component, OnInit, ViewEncapsulation } from '@angular/core';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  encapsulation: ViewEncapsulation.None,
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  constructor(private formBuilder: FormBuilder) {} 
	
	registerForm: FormGroup;
	result: string;

	validateFormControl = new FormControl('', [
		Validators.required,
		Validators.email,
	]);

	ngOnInit() {
		this.registerForm = this.formBuilder.group({
			username: ['', Validators.required],
			password: ['', Validators.required]
		});
  }
	
		
  login() {
    console.log(this.registerForm.controls);
  }

}
