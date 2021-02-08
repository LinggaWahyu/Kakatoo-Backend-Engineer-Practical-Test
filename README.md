# Knowledge and Experience Test

1. Tantangan terbesar yang sering saya temui saat membangun sebuah web application yaitu masih belum mengerti penyelesaian dalam source code pada masalah tertentu, misal seperti harus menggunakan sebuah package/library tertentu yang belum pernah saya pelajari sebelumnya. Biasanya saya menyelesaikan hal tersebut yaitu dengan membaca dokumentasi dari package/libray tersebut, kemudian mencari tutorial di google atau di youtube, serta bertanya kepada teman atau orang yang lebih berpengalaman daripada saya.

2. Ya, menurut saya clean code itu adalah suatu source code yang disusun dengan format yang baik dan benar sehingga programmer yang membaca source code dapat dengan mudah memahami atau memodifikasinya. Adapun implementasi saya dalam menerapkan clean code ini adalah dengan menuliskan variabel, method ataupun class dengan singkat, padat, jelas dan sesuai dengan contexnya, lalu kadang dengan menghindari ambiguitas pada percabangan, menggunakan Coding Style yang banyak digunakan orang dan terakhir menghapus code-code yang tidak diperlukan.

3. Ya saya menggunakannya ketika membangung sebuah project dengan sebuah tim, biasanya saya menggunakan 2 branch untuk merekam history dari project yaitu master branch dan develop branch. Master branch digunakan untuk official release history, sedangkan develop branch digunakan untuk mengintregasikan brach untuk features-nya. Lalu ketika release branch develop tersebut akan di merge ke dalam master.

4. Sepengetahuan saya design pattern itu seperti solusi dari permasalahan-permasalahan umum yang sering kali terjadi dalam pengembangan suatu software atau aplikasi. Untuk sampai sekarang saya belum pernah menggunakan design pattern dalam pengembangan suatu web application.

5. Ya saya bersedia, jika memang harus remote untuk komunikasi dan kolaborasi pengerjaan project kita dapat menggunakan aplikasi task management seperti Trello lalu pembagin tugas nya di bagi se-efisien mungkin, dan mungkin setiap hari atau beberapa waktu sekali mengadakan meet untuk dapat berkomunikasi, berdiskusi ataupun progress sementara pengerjaan project.


# Cara Instalasi/Run

-   Clone repository ini

```sh
$ git clone https://github.com/LinggaWahyu/Kakatoo-Backend-Engineer-Practical-Test.git
```

-   Masuk ke dalam lokasi folder aplikasi

```sh
$ cd Kakatoo-Backend-Engineer-Practical-Test/kakatoo-backend-engineer-practical-test/
```

-   Install dependencies dengan menjalankan perintah

```sh
$ composer install
```

- Lalu jalankan perintah

```sh
$ npm install && npm run dev
```

-   Buat file .env dengan berdasarkan file .env.example

```sh
$ cp .env.example .env
```

-   Setelah berhasil membuat file .env, beirkutnya jalankan perintah

```sh
$ php artisan key:generate
```

-   Buat database baru dengan nama **kakatoo_backend_engineer_practical_test**

-   Setelah selesai membuat database, jalankan perintah berikut

```sh
$ php artisan migrate
```

-   Terakhir, untuk membukanya di web browser, jalankan perintah

```sh
$ php artisan serve
```

-   Lalu jalankan http://localhost:8000

-   Register akun terlebih dahulu melalui API untuk menjalankan aplikasi

# Screenshoot Web Page **List of Activities**
![screenshoot-1](/Screenshoot/Login_Page.png?raw=true "Login Page")
![screenshoot-2](/Screenshoot/Home_Page.png?raw=true "Home Page")
![screenshoot-3](/Screenshoot/List_of_Participan_Modal.png?raw=true "List of Participan Modal")
![screenshoot-4](/Screenshoot/Logout_modal.png?raw=true "Logout Modal")

- Trainer Home Page
![screenshoot-6](/Screenshoot/Trainer_Home.png?raw=true "Trainer Home Page")

- Board Home Page (Register User)
![screenshoot-5](/Screenshoot/Board_Home.png?raw=true "Board Home Page (Register User)")

- Expert Home Page 
![screenshoot-7](/Screenshoot/Expert_Home.png?raw=true "Expert Home Page")

- Expert Create Activity
![screenshoot-8](/Screenshoot/Expert_Create_Activity.png?raw=true "Expert Create Activity")

- Expert Edit Activity
![screenshoot-9](/Screenshoot/Expert_Edit_Activity.png?raw=true "Expert Edit Activity")
