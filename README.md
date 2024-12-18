# Kelas B Kelompok 6

## *Anggota Kelompok*:
- *Eliandani Andreskia Setiawan (220711965)* - Frontend & Integrasi
- *Daniel Noveno Windanu (220711663)* - Frontend & Backend
- *Josua Waraney William Lantang (220712071)* - Frontend & Integrasi
- *Bernadetta Amelia Naibaho (220712029)* - Support

---

## *Username & Password Login*
### *Login User*
- *Username*: daniel@gmail.com  
- *Password*: daniel123  

### *Login Admin*
- *Username*: admin@example.com  
- *Password*: admin123

---

## *Bonus yang Diambil*
### *Hosting*
- *Backend*: [https://gym5api-production.up.railway.app/](https://gym5api-production.up.railway.app/)
- *Frontend*: [https://pw-b-6-react.vercel.app/](https://pw-b-6-react.vercel.app/)

### *React*
- *Link Repository*: [https://github.com/danielnoveno/PW_B_6_React](https://github.com/danielnoveno/PW_B_6_React)

### *Laravel Backend*
- *Link Repository*: [https://github.com/danielnoveno/PW_B_6_Laravel](https://github.com/danielnoveno/PW_B_6_Laravel)

---

## *Routes API*
### *User Routes*
- POST /register - Register a new user  
- POST /login - Login as a user  
- POST /logout - Logout the authenticated user  
- GET /user - Get all users  
- GET /user/{id} - Get a single user by ID  
- PUT /user/{id} - Update user by ID  
- DELETE /user/{id} - Delete user by ID  
- POST /user/change-password - Change user password  
- GET /user/count - Get total count of users  

### *Admin Routes*
- POST /admin/register - Register a new admin  
- POST /admin/login - Login as an admin  
- POST /admin/logout - Logout the authenticated admin  
- GET /admin - Get all admins  
- GET /admin/{id} - Get a single admin by ID  
- PUT /admin/{id} - Update admin by ID  
- DELETE /admin/{id} - Delete admin by ID  

### *Buku (Book) Routes*
- GET /buku - Get all books  
- GET /buku/{id} - Get a single book by ID  
- POST /buku - Add a new book  
- PUT /buku/{id} - Update a book by ID  
- DELETE /buku/{id} - Delete a book by ID  
- GET /buku/isbn/{isbn} - Get a book by ISBN  
- PUT /buku/isbn/{isbn} - Update a book by ISBN  
- DELETE /buku/isbn/{isbn} - Delete a book by ISBN  
- GET /buku/admin - Get all books for admin  

### *Bookmark Routes*
- GET /bookmarks - Get all bookmarks for authenticated user  
- POST /bookmarks - Add a book to bookmarks  
- GET /bookmarks/{id} - Get a single bookmark  
- PUT /bookmarks/{id} - Update a bookmark  
- DELETE /bookmarks/{id} - Remove a bookmark  

### *Transaksi Routes*
- GET /transaksi - Get all transactions  
- POST /transaksi - Create a new transaction  
- GET /transaksi/{id} - Get a single transaction  
- PUT /transaksi/{id} - Update transaction details  
- DELETE /transaksi/{id} - Delete a transaction  

### *Rekomendasi Routes*
- GET /rekomendasi - Get all recommendations  
- POST /rekomendasi - Create a new recommendation  
- GET /rekomendasi/{id} - Get a single recommendation  
- PUT /rekomendasi/{id} - Update a recommendation  
- DELETE /rekomendasi/{id} - Delete a recommendation  

### *Log Aktivitas Routes*
- GET /log-aktivitas - Get all activity logs  
- POST /log-aktivitas - Create a new activity log  
- GET /log-aktivitas/{id} - Get a single activity log  
- PUT /log-aktivitas/{id} - Update activity log details  
- DELETE /log-aktivitas/{id} - Delete an activity log  

### *Riwayat Routes*
- GET /riwayat - Get all history records  
- POST /riwayat - Create a new history record  
- GET /riwayat/{id} - Get a single history record  
- PUT /riwayat/{id} - Update history details  
- DELETE /riwayat/{id} - Delete a history record
