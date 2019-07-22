import { Injectable } from '@angular/core';
import {CoreService} from "../../core.service";
import {ActivatedRoute, Router} from "@angular/router";
import {MatSnackBar} from "@angular/material";

@Injectable({
  providedIn: 'root'
})
export class RegisterService {

  constructor(private coreService: CoreService, private route: ActivatedRoute,
              private router: Router, public snackBar: MatSnackBar) { }

    register(data) {
        return this.coreService.post(`signup`, data)
            .subscribe(result => {
                console.log(result);
                this.snackBar.open('Usuário cadastrado com sucesso!', null, {
                    duration: 2000,
                    verticalPosition: 'bottom',
                    horizontalPosition:'right'
                });
                this.router.navigate(['/login']);
            }, error => {
                //console.log(error);
            });
    }

}
