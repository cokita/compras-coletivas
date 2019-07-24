import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor() { }

    getUser(){
        const all =JSON.parse(localStorage.getItem('currentUser'));
        if(all.user){
            return all.user;
        }
    }
}
