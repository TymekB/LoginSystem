import {Injectable} from '@angular/core';
import {AbstractControl, AsyncValidator, ValidationErrors} from '@angular/forms';
import {UserRepositoryService} from '../user-repository.service';
import {map} from 'rxjs/operators';
import {Observable} from 'rxjs';
import 'rxjs-compat/add/operator/map';

@Injectable({ providedIn: 'root' })

export class UniqueUsernameValidator {

    static createValidator(userRepository: UserRepositoryService) {
        return (control: AbstractControl) => {
            return userRepository.findByUsername(control.value).pipe(
                map(value => value['success'] ? {usernameTaken: true} : null));
        };
    }
}
