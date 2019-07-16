import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { FormBuilder, FormGroup, FormControl, Validators } from '@angular/forms';

import { LoginService} from './login.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  encapsulation: ViewEncapsulation.None,
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  loginForm: FormGroup;
  result: string;

  validateFormControl = new FormControl('', [
      Validators.required,
      Validators.email,
  ]);


  constructor(private formBuilder: FormBuilder, private loginService: LoginService) {
  }

  ngOnInit() {
      this.loginForm = this.formBuilder.group({
          email: ['', Validators.required],
          password: ['', Validators.required]
      });

      this.loginService.logout();
  }

  get f() { return this.loginForm.controls; }

  login() {
      console.log(this.f.email.value, this.f.password.value);

      this.loginService.login(this.f.email.value, this.f.password.value).add(result => {
          console.log(result);
      });
          // .subscribe(
          //     data => {
          //         this.router.navigate([this.returnUrl]);
          //     },
          //     error => {
          //         this.alertService.error(error);
          //         this.loading = false;
          //     });
  }
}
