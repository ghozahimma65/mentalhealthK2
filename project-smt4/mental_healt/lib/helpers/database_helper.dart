// Nama file: lib/helpers/database_helper.dart
import 'package:sqflite/sqflite.dart';
import 'package:path/path.dart';
import 'package:path_provider/path_provider.dart';
import 'dart:async';

import '../models/self_care_plan.dart'; // Sesuaikan path ke model Anda

class DatabaseHelper {
  static const _databaseName = "SelfCareAppDB.db"; // Nama database
  static const _databaseVersion = 1; // Versi database

  static const tablePlans = 'self_care_plans'; // Nama tabel
  // Nama kolom (samakan dengan keys di SelfCarePlan.toMap() dan .fromMap())
  static const columnId = 'id';
  static const columnTitle = 'title';
  static const columnDescription = 'description';
  static const columnIsCompleted = 'isCompleted';
  // static const columnReminderTime = 'reminderTime';

  // Singleton class
  DatabaseHelper._privateConstructor();
  static final DatabaseHelper instance = DatabaseHelper._privateConstructor();

  static Database? _database;
  Future<Database> get database async {
    if (_database != null) return _database!;
    _database = await _initDatabase();
    return _database!;
  }

  // Inisialisasi database
  Future<Database> _initDatabase() async {
    final documentsDirectory = await getApplicationDocumentsDirectory();
    final path = join(documentsDirectory.path, _databaseName);
    print("Database path: $path");
    return await openDatabase(path,
        version: _databaseVersion, onCreate: _onCreate);
  }

  // Buat tabel saat database dibuat
  Future _onCreate(Database db, int version) async {
    await db.execute('''
          CREATE TABLE $tablePlans (
            $columnId TEXT PRIMARY KEY,
            $columnTitle TEXT NOT NULL,
            $columnDescription TEXT,
            $columnIsCompleted INTEGER NOT NULL DEFAULT 0 
          )
          ''');
    print("Tabel $tablePlans berhasil dibuat.");
  }

  // Operasi CRUD (Create, Read, Update, Delete)

  Future<int> insertPlan(SelfCarePlan plan) async {
    Database db = await instance.database;
    print("Inserting plan: ${plan.toMap()}");
    return await db.insert(tablePlans, plan.toMap(), conflictAlgorithm: ConflictAlgorithm.replace);
  }

  Future<List<SelfCarePlan>> getAllPlans() async {
    Database db = await instance.database;
    final List<Map<String, dynamic>> maps = await db.query(tablePlans); // Ambil semua baris
    print("Fetched ${maps.length} plans from database.");
    if (maps.isEmpty) return [];
    return List.generate(maps.length, (i) {
      return SelfCarePlan.fromMap(maps[i]);
    });
  }

  Future<int> updatePlan(SelfCarePlan plan) async {
    Database db = await instance.database;
    print("Updating plan: ${plan.toMap()}");
    return await db.update(tablePlans, plan.toMap(),
        where: '$columnId = ?', whereArgs: [plan.id]);
  }

  Future<int> deletePlan(String id) async {
    Database db = await instance.database;
    print("Deleting plan with id: $id");
    return await db.delete(tablePlans, where: '$columnId = ?', whereArgs: [id]);
  }
}