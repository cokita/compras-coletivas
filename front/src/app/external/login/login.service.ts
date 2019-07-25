import {Injectable} from '@angular/core';
import {CoreService} from 'src/app/core.service';
import {ActivatedRoute, Router} from '@angular/router';
import {MatSnackBar} from "@angular/material";
import { environment } from '../../../environments/environment';

@Injectable({
    providedIn: 'root'
})
export class LoginService {
    returnUrl: string;

    constructor(private coreService: CoreService, private route: ActivatedRoute,
                private router: Router, private snackBar: MatSnackBar) {
        this.returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/admin';
    }

    login(email: string, password: string) {
        return this.coreService.post(`oauth/token`, {
            grant_type:'password',
            client_id:environment.client_id,
            client_secret:environment.client_secret,
            username:email,
            password:password
        }).subscribe(result => {
                if (result && result.access_token) {
                    localStorage.setItem('currentUser', JSON.stringify(result));
                    this.router.navigate([this.returnUrl]);
                } else {
                    this.snackBar.open('Não foi possível efetuar o login, tente novamente mais tarde.', null, {
                        duration: 2000,
                        verticalPosition: 'bottom',
                        horizontalPosition:'right'
                    });
                    this.router.navigate(['/login']);
                    return false;
                }
            });
    }

    logout() {
        localStorage.removeItem('currentUser');
        this.router.navigate(['/login']);
    }

    getUser() {
        const all = JSON.parse(localStorage.getItem('currentUser'));
        if (all.user) {
            return all.user;
        }
    }

    getToken() {
        const all = JSON.parse(localStorage.getItem('currentUser'));
        if (all.token) {
            return all.token;
        }
    }
}
