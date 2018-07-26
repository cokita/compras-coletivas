import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { map } from 'rxjs/operators'; 
 
@Injectable()
export class UserService {
 
  // URL da nossa API
  private url: string = "http://localhost:3000/questions";
 
  constructor(private http: Http) { }
 
  getUser(){
    return this.http.get(this.url)
      .pipe(map( res => res.json()));
  }
 
  getQuestion(id){
    return this.http.get(this.url + '/' + id)
      .pipe(map(res => res.json()));
  }
 
  addUser(user){
    console.log(user);
    return this.http.post(this.url, {'user': user})
      .pipe(map(res => res.json()));
  }
 
  updateUser(user){
    return this.http.put(this.url + '/' + user.id, {'user': user})
      .pipe(map(res => res.json()));
  }
 
  deleteUser(id){
    return this.http.delete(this.url + '/' + id)
      .pipe(map(res => res.json()));
  }
 
}