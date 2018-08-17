import {FormBuilder, FormGroup, FormControl, Validators} from '@angular/forms';
import {Component, OnInit, ViewEncapsulation} from '@angular/core';

import { CoreService } from "../../core.service";

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    encapsulation: ViewEncapsulation.None,
    styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

    registerForm: FormGroup;
    result: string;

    validateFormControl = new FormControl('', [
        Validators.required,
        Validators.email,
    ]);


    constructor(private formBuilder: FormBuilder, private coreService: CoreService) {
    }

    ngOnInit() {
        this.coreService.get('user/1').subscribe(function(restult){
           console.log(restult);
        });

        this.registerForm = this.formBuilder.group({
            username: ['', Validators.required],
            password: ['', Validators.required]
        });
    }

    login() {
        console.log(this.registerForm.controls);
    }

}
