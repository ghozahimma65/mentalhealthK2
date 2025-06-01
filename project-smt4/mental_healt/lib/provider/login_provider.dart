import 'package:get/get_connect/connect.dart';
import 'package:mobile_project/ApiVar.dart';

class LoginProvider extends GetConnect {
  Future<Response> auth(var data) {
    print(LoginAPI);
    return post(LoginAPI, data);
  }
}
