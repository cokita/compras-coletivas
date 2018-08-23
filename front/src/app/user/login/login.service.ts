import { Injectable } from '@angular/core';
import { CoreService } from "../../core.service";
import { Router, ActivatedRoute } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class LoginService {
    returnUrl: string;

    constructor(private coreService: CoreService, private route: ActivatedRoute,
                private router: Router) {
        this.returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/';
    }

    login(email: string, password: string) {
        return this.coreService.post(`/login`, { email: email, password: password })
            .subscribe(result => {
                console.log(result);
                if (result && result.user && result.access_token) {
                    localStorage.setItem('currentUser', JSON.stringify(result));
                }
                this.router.navigate([this.returnUrl]);
                return result.user;
            });
    }

    logout() {
        localStorage.removeItem('currentUser');
        this.router.navigate(['/login']);
    }

    getUser(){
        let all =JSON.parse(localStorage.getItem('currentUser'));
        if(all.user){
            return all.user;
        }
    }
}
