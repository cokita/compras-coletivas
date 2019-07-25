import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class GlobalService {

  constructor() { }

  async asyncForEach(array, callback) {
      for (let index = 0; index < array.length; index++) {
          await callback(array[index], index, array);
      }
  }
}
