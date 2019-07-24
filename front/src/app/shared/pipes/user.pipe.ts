import { Pipe, PipeTransform } from '@angular/core';
import {UserService} from "../../internal/user/user.service";

@Pipe({
  name: 'user'
})
export class UserPipe implements PipeTransform {
  constructor(private userService: UserService){}

  async transform(value: any): any {
      let actions = await this.userService.getActions();
      if (actions && actions.indexOf(value) !== -1){
          return true;
      }

      return false;
  }

}
