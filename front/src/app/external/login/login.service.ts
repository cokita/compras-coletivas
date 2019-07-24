import {Injectable} from '@angular/core';
import {CoreService} from 'src/app/core.service';
import {ActivatedRoute, Router} from '@angular/router';
import {MatSnackBar} from "@angular/material";

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
        return this.coreService.post(`login`, {email: email, password: password})
            .subscribe(result => {
                if (result && result.user && result.access_token && result.user.profiles) {
                    localStorage.setItem('currentUser', JSON.stringify(result));
                    this.setProfiles(result.user.profiles);
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

    setProfiles(profiles) {
        console.log(profiles);
        let arrAcoesPerfis = [];
        profiles.forEach(objProfiles => {
            let arrAcoes = objProfiles.actions;
            let tagMap = arrAcoes.reduce(function (map, tag) {
                map[tag.id] = tag.name;
                return map;
            }, {});

            if(arrAcoesPerfis.length <= 0){
                arrAcoesPerfis = Object.values(tagMap);
            }else{
                arrAcoesPerfis = arrAcoesPerfis.concat(Object.values(tagMap).filter(function (item) {
                    return arrAcoesPerfis.indexOf(item) < 0;
                }));
            }
        });

        localStorage.setItem('actions_'+this.getUser().id, JSON.stringify(arrAcoesPerfis));

        return arrAcoesPerfis;
    }
}
