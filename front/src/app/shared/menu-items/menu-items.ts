import { Injectable } from '@angular/core';

export interface Menu {
    state: string;
    name: string;
    type: string;
    icon: string;
}

const MENUITEMS = [
    {state: 'home',      type: 'link', name: 'Início', icon: 'av_timer' },
    {state: 'users',     type: 'link', name: 'Usuários', icon: 'person'},
    {state: 'groups',    type: 'link', name: 'Grupos de Vendas', icon: 'shopping_basket'}

];

@Injectable()

export class MenuItems {
    getMenuitem(): Menu[] {
        return MENUITEMS;
    }

}
