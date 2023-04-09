import wave
from tkinter import *
from tkinter import ttk
from PIL import Image, ImageTk
import mysql.connector
from tkinter import messagebox

class Student:
    def __init__(self, root):
        self.root = root;
        self.root.geometry("1530x790+0+0")
        self.root.title("Student Management System")

        #variables
        self.var_dep = StringVar()
        self.var_course = StringVar()
        self.var_year = StringVar()
        self.var_semester = StringVar()
        self.var_std_id = StringVar()
        self.var_std_name = StringVar()
        self.var_div = StringVar()
        self.var_roll = StringVar()
        self.var_gender = StringVar()
        self.var_dob = StringVar()
        self.var_email = StringVar()
        self.var_phone = StringVar()
        self.var_address = StringVar()
        self.var_teacher = StringVar()

        #1st
        img = Image.open("Images/1st.jpg")
        img = img.resize((1530, 160), Image.ANTIALIAS)
        self.photoimg = ImageTk.PhotoImage(img)

        self.btn_1 = Button(self.root,image=self.photoimg, cursor="hand2")
        self.btn_1.place(x=0, y=0, width=1530, height=160)



        # bg image
        img4 = Image.open(r"Images\bg_bl.jpg")
        img4 = img4.resize((1530, 710), Image.ANTIALIAS)
        self.photoimg_4 = ImageTk.PhotoImage(img4)

        bg_lbl = Label(self.root,image=self.photoimg_4,bd=2,relief=RIDGE)
        bg_lbl.place(x=0, y=160, width=1530,height=710)

        lbl_title = Label(bg_lbl, text= "STUDENT MANAGEMENT SYSTEM", font=("times new roman",37,"bold"),fg="red",bg="black")
        lbl_title.place(x=0, y=0, width=1530, height=50)

        #manage frame
        manage_frame = Frame(bg_lbl,bd=2,relief=RIDGE,bg="white")
        manage_frame.place(x=15,y=55,width=1500,height=560)


        #Left frame
        dataLeftFrame =LabelFrame(manage_frame,bd=4, relief=RIDGE,padx=2,text="Student Information", font=("times new roman",12,"bold"),fg="black",bg="white")
        dataLeftFrame.place(x=10,y=10,width=660,height=540)

        #img1
        img5 = Image.open(r"Images\ewu.jpg")
        img5 = img5.resize((650, 120), Image.ANTIALIAS)
        self.photoimg_5 = ImageTk.PhotoImage(img5)

        my_img = Label(dataLeftFrame, image=self.photoimg_5, bd=2, relief=RIDGE)
        my_img.place(x=0, y=0, width=650, height=120)

        # current course LabelFrame Information
        std_lbl_info_frame = LabelFrame(dataLeftFrame, bd=4, relief=RIDGE, padx=2, text="Current Course Information", font=("times new roman", 12, "bold"), fg="black", bg="white")
        std_lbl_info_frame.place(x=0, y=120, width=650, height=115)

        # Labels  & Combobox
        # Department
        lbl_dept = Label(std_lbl_info_frame,text="Department",font=("arial", 12, "bold"), bg="white")
        lbl_dept.grid(row=0,column=0,padx=2)

        combo_dept=ttk.Combobox(std_lbl_info_frame, textvariable=self.var_dep,font=("arial", 12, "bold"),width=17,state="readonly")
        combo_dept["value"] = ("Select Department","CSE","ECE","ICE","EEE","BBA","English","GEB","Economics","Pharmacy", "Civil","Sociology")
        combo_dept.current(0)
        combo_dept.grid(row=0,column=1,padx=2,pady=10)

        # Course
        lbl_course = Label(std_lbl_info_frame, text="Course", font=("arial", 12, "bold"), bg="white")
        lbl_course.grid(row=0, column=2, padx=2,pady=10)

        combo_course = ttk.Combobox(std_lbl_info_frame,textvariable=self.var_course, font=("arial", 12, "bold"), width=17, state="readonly")
        combo_course["value"] = (
        " Select Course",
        "CSE103",
        "CSE106",
        "CSE302",
        "CSE325",
        "CSE405",
        "ENG101",
        "ENG102",
        "MAT101",
        "MAT104",
        "SOC101",
        "MKT101",
        "BBA101",
        "GEB101",
        "PHY109",
        "FIN101",
        "BUS321",
        "GEN226",
        "CIV101",
        "ECE101",
        "ICE101",
        "ICE110",
        "ETE101",
        "ECO101",
        "STA101",
        "STA102",
        "ENG200",
        "GEB301",
        "SOC400",
        "ACT101",
        "CSE200",
        )
        combo_course.current(0)
        combo_course.grid(row=0, column=3, padx=2, pady=10)

        # Year
        current_year = Label(std_lbl_info_frame, text="Year", font=("arial", 12, "bold"), bg="white")
        current_year.grid(row=1, column=0, padx=2)


        com_txt_current_year = ttk.Combobox(std_lbl_info_frame,textvariable=self.var_year, font=("arial", 12, "bold"), width=17, state="readonly")
        com_txt_current_year["value"] = (
        "Select Year", "2015", "2016", "2017", "2018", "2019", "2020", "2021", "2022")
        com_txt_current_year.current(0)
        com_txt_current_year.grid(row=1, column=1, padx=2, pady=10)

        # Semester
        label_semester = Label(std_lbl_info_frame, text="Semester", font=("arial", 12, "bold"), bg="white")
        label_semester.grid(row=1, column=2,padx=2,pady=10)

        com_semester = ttk.Combobox(std_lbl_info_frame,textvariable=self.var_semester, font=("arial", 12, "bold"), width=17, state="readonly")
        com_semester["value"] = (
            "Select Semester", "Spring", "Summer", "Fall")
        com_semester.current(0)
        com_semester.grid(row=1, column=3, padx=2, pady=10)

        # Student Class label Information
        std_lbl_class_frame = LabelFrame(dataLeftFrame, bd=4, relief=RIDGE, padx=2, text="Class Course Information",
                                        font=("times new roman", 12, "bold"), fg="black", bg="white")
        std_lbl_class_frame.place(x=0, y=235, width=650, height=235)

        # Labels Entry
        # ID
        lbl_id = Label(std_lbl_class_frame, text="Student ID:", font=("arial", 12, "bold"), bg="white")
        lbl_id.grid(row=0, column=0, padx=2, pady=7)

        id_entry= ttk.Entry(std_lbl_class_frame,textvariable=self.var_std_id,font=("arial", 12, "bold"),width=22)
        id_entry.grid(row=0, column=1, padx=2, pady=7)

        #Name
        lbl_name = Label(std_lbl_class_frame, text="Name:", font=("arial", 12, "bold"), bg="white")
        lbl_name.grid(row=0, column=2, padx=2, pady=7)

        name_entry = ttk.Entry(std_lbl_class_frame,textvariable=self.var_std_name, font=("arial", 12, "bold"), width=22)
        name_entry.grid(row=0, column=3, padx=2, pady=7)

        # Section
        lbl_div = Label(std_lbl_class_frame, text="Section:", font=("arial", 12, "bold"), bg="white")
        lbl_div.grid(row=1, column=0, padx=2, pady=7)


        sec_txt = ttk.Entry(std_lbl_class_frame, textvariable=self.var_div,font=("arial", 12, "bold"), width=22)
        sec_txt.grid(row=1,column=1,padx=2,pady=7)

        #com_txt_div = ttk.Combobox(std_lbl_class_frame, textvariable=self.var_div,font=("arial", 12, "bold"), width=20, state="readonly")
        #com_txt_div["value"] = (
            #"Select Division", "Dhaka", "Chittagong", "Rajshahi","Khulna","Barisal","Sylhet")
        #com_txt_div.current(0)
       # com_txt_div.grid(row=1, column=1, padx=2, pady=7)

        # CGPA
        lbl_roll = Label(std_lbl_class_frame, text="CGPA :", font=("arial", 12, "bold"), bg="white")
        lbl_roll.grid(row=1, column=2, padx=2, pady=7)

        roll_txt = ttk.Entry(std_lbl_class_frame, textvariable=self.var_roll,font=("arial", 12, "bold"), width=22)
        roll_txt.grid(row=1, column=3, padx=2, pady=7)

        # Gender
        lbl_gen = Label(std_lbl_class_frame, text="Gender :", font=("arial", 12, "bold"), bg="white")
        lbl_gen.grid(row=2, column=0, padx=2, pady=7)

        com_txt_gender = ttk.Combobox(std_lbl_class_frame,textvariable=self.var_gender, font=("arial", 12, "bold"), width=20, state="readonly")
        com_txt_gender["value"] = (
            "Gender", "Male", "Female", "Other")
        com_txt_gender.current(0)
        com_txt_gender.grid(row=2, column=1, padx=2, pady=7)

        # DOB
        lbl_DOB = Label(std_lbl_class_frame, text="DOB :", font=("arial", 12, "bold"), bg="white")
        lbl_DOB.grid(row=2, column=2, padx=2, pady=7)

        DOB_txt = ttk.Entry(std_lbl_class_frame,textvariable=self.var_dob, font=("arial", 12, "bold"), width=22)
        DOB_txt.grid(row=2, column=3, padx=2, pady=7)

        # Email
        lbl_email = Label(std_lbl_class_frame, text="Email :", font=("arial", 12, "bold"), bg="white")
        lbl_email.grid(row=3, column=0, padx=2, pady=7)

        email_txt = ttk.Entry(std_lbl_class_frame,textvariable=self.var_email, font=("arial", 12, "bold"), width=22)
        email_txt.grid(row=3, column=1, padx=2, pady=7)

        # Phone
        lbl_phone = Label(std_lbl_class_frame, text="Phone :", font=("arial", 12, "bold"), bg="white")
        lbl_phone.grid(row=3, column=2, padx=2, pady=7)

        phone_txt = ttk.Entry(std_lbl_class_frame,textvariable=self.var_phone, font=("arial", 12, "bold"), width=22)
        phone_txt.grid(row=3, column=3, padx=2, pady=7)

        # Address
        lbl_address = Label(std_lbl_class_frame, text="Address :", font=("arial", 12, "bold"), bg="white")
        lbl_address.grid(row=4, column=0, padx=2, pady=7)

        address_txt = ttk.Entry(std_lbl_class_frame,textvariable=self.var_address, font=("arial", 12, "bold"), width=22)
        address_txt.grid(row=4, column=1, padx=2, pady=7)

        # Advisor
        lbl_advisor = Label(std_lbl_class_frame, text="Advisor :", font=("arial", 12, "bold"), bg="white")
        lbl_advisor.grid(row=4, column=2, padx=2, pady=7)

        advisor_txt = ttk.Entry(std_lbl_class_frame,textvariable=self.var_teacher, font=("arial", 12, "bold"), width=22)
        advisor_txt.grid(row=4, column=3, padx=2, pady=7)

        # button frame
        button_frame = Frame(dataLeftFrame, bd=2, relief=RIDGE, bg="white")
        button_frame.place(x=0, y=470, width=650, height=38)

        # Add
        btn_add = Button(button_frame, text="Insert", command=self.add_data, font=("arial", 12, "bold"), width=15,bg="Black",fg="red")
        btn_add.grid(row=0, column=0, padx=1)

        # Update
        btn_update = Button(button_frame, text="Update",command=self.update_data, font=("arial", 12, "bold"), width=15, bg="Black", fg="red")
        btn_update.grid(row=0, column=1, padx=1)

        # Delete
        btn_delete = Button(button_frame, text="Delete",command=self.delete_data,font=("arial", 12, "bold"), width=15, bg="Black", fg="red")
        btn_delete.grid(row=0, column=2, padx=1)

        # Reset
        btn_reset = Button(button_frame, text="Reset",command=self.reset_data,font=("arial", 12, "bold"), width=15, bg="Black", fg="red")
        btn_reset.grid(row=0, column=3, padx=1)

        # Right frame
        dataRightFrame = LabelFrame(manage_frame, bd=4, relief=RIDGE, padx=2, text="Student Information", font=("times new roman", 12, "bold"), fg="black", bg="white")
        dataRightFrame.place(x=680, y=10, width=800, height=540)

        #img_6
        img_right= Image.open("Images\ewu_ground.jpg")
        img_right = img_right.resize((780,200), Image.ANTIALIAS)
        self.photoimg_right = ImageTk.PhotoImage(img_right)

        my_img_right = Label(dataRightFrame,image=self.photoimg_right,bd=2,relief=RIDGE)
        my_img_right.place(x=0,y=0, width=790,height=200)

        # Search Frame
        searchFrame = LabelFrame(dataRightFrame, bd=4, relief=RIDGE, padx=2, text="Search Student Information", font=("times new roman", 12, "bold"), fg="black", bg="white")
        searchFrame.place(x=0, y=200, width=790, height=60)

        # Label
        search_by = Label(searchFrame, text="Search By :", font=("arial", 11, "bold"), fg="Black", bg="white")
        search_by.grid(row=0, column=0, padx=2, pady=7)

        # search Combobox
        self.var_com_search = StringVar()
        com_txt_search = ttk.Combobox(searchFrame,textvariable=self.var_com_search, font=("arial", 12, "bold"), width=20, state="readonly")
        com_txt_search["value"] = (
            "Select Option", "Student_Id","Department","Year")
        com_txt_search.current(0)
        com_txt_search.grid(row=0, column=1, padx=5)

        #searchBox

        self.var_search = StringVar()
        search_txt = ttk.Entry(searchFrame,textvariable=self.var_search, font=("arial", 12, "bold"), width=22)
        search_txt.grid(row=0, column=2, padx=5)

        # button
        btn_search = Button(searchFrame, text="Search",command=self.search_data ,font=("arial", 12, "bold"), width=12, bg="Black", fg="red")
        btn_search.grid(row=0, column=3, padx=1)

        btn_show = Button(searchFrame, text="Show",command=self.fetch_data, font=("arial", 12, "bold"), width=12, bg="Black", fg="red")
        btn_show.grid(row=0, column=4, padx=1)

        # =====================Student Table and Scroll bar=================

        table_frame = Frame(dataRightFrame,bd=4,relief=RIDGE)
        table_frame.place(x=0,y=260,width=790,height=250)

        # Scroll bar
        scroll_x = ttk.Scrollbar(table_frame,orient=HORIZONTAL)
        scroll_y = ttk.Scrollbar(table_frame, orient=VERTICAL)
        self.student_table= ttk.Treeview(table_frame,columns=("dep","course","year","sem","id","name","div","roll","gender","dob","email","phone","address","teacher"),xscrollcommand=scroll_x.set,yscrollcommand=scroll_y.set)

        scroll_x.pack(side=BOTTOM,fill=X)
        scroll_y.pack(side=RIGHT,fill=Y)

        scroll_x.config(command=self.student_table.xview)
        scroll_y.config(command=self.student_table.yview)

        self.student_table.heading("dep", text="Department")
        self.student_table.heading("course", text="Course")
        self.student_table.heading("year", text="Year")
        self.student_table.heading("sem", text="Semester")
        self.student_table.heading("id", text="StudentID")
        self.student_table.heading("name", text="Student Name")
        self.student_table.heading("div", text="Section")
        self.student_table.heading("roll", text="CGPA")
        self.student_table.heading("gender", text="Gender")
        self.student_table.heading("dob", text="DOB")
        self.student_table.heading("email", text="Email")
        self.student_table.heading("phone", text="Phone No")
        self.student_table.heading("address", text="Address")
        self.student_table.heading("teacher", text="Advisor")



        self.student_table["show"] = "headings"
        self.student_table.column("dep", width=80)
        self.student_table.column("course",width=80)
        self.student_table.column("year", width=80)
        self.student_table.column("sem", width=80)
        self.student_table.column("id", width=80)
        self.student_table.column("name", width=80)
        self.student_table.column("div", width=80)
        self.student_table.column("roll", width=80)
        self.student_table.column("gender", width=80)
        self.student_table.column("dob", width=80)
        self.student_table.column("email", width=80)
        self.student_table.column("phone", width=80)
        self.student_table.column("address", width=80)
        self.student_table.column("teacher", width=80)


        self.student_table.pack(fill=BOTH, expand=1)
        self.student_table.bind("<ButtonRelease>",self.get_cursor)
        self.fetch_data()




    # Data insert function
    def add_data(self):
        if (self.var_dep.get() == " "or self.var_std_id.get() == ""or self.var_email.get() == ""):
            messagebox.showerror("Error", "All the fields are required")
        else:
            try:
                conn = mysql.connector.connect(host="localhost", username="root", password="11608554", database="sms")
                my_cursor = conn.cursor()
                my_cursor.execute("INSERT INTO student VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",(
                                        self.var_dep.get(),
                                        self.var_course.get(),
                                        self.var_year.get(),
                                        self.var_semester.get(),
                                        self.var_std_id.get(),
                                        self.var_std_name.get(),
                                        self.var_div.get(),
                                        self.var_roll.get(),
                                        self.var_gender.get(),
                                        self.var_dob.get(),
                                        self.var_email.get(),
                                        self.var_phone.get(),
                                        self.var_address.get(),
                                        self.var_teacher.get()
                                                    ))
                conn.commit()
                self.fetch_data()
                conn.close()
                messagebox.showinfo("Success", "Student data inserted")
            except Exception as es:
                messagebox.showerror("Error", f"Due to {str(es)}", parent=self.root)

    # fetch function
    def fetch_data(self):
        conn = mysql.connector.connect(host="localhost", username="root", password="11608554", database="sms")
        my_cursor = conn.cursor()
        my_cursor.execute("select * from student")
        data=my_cursor.fetchall()
        if len(data)!=0:
            self.student_table.delete(*self.student_table.get_children())
            for i in data:
                self.student_table.insert("",END,values=i)
            conn.commit()
            conn.close()

    # Get Cursor
    def get_cursor(self,event=""):
        cursor_row = self.student_table.focus()
        content = self.student_table.item(cursor_row)
        data=content["values"]

        self.var_dep.set(data[0])
        self.var_course.set(data[1])
        self.var_year.set(data[2])
        self.var_semester.set(data[3])
        self.var_std_id.set(data[4])
        self.var_std_name.set(data[5])
        self.var_div.set(data[6])
        self.var_roll.set(data[7])
        self.var_gender.set(data[8])
        self.var_dob.set(data[9])
        self.var_email.set(data[10])
        self.var_phone.set(data[11])
        self.var_address.set(data[12])
        self.var_teacher.set(data[13])


    # Update data
    def update_data(self):
        if (self.var_dep.get() == " " or self.var_std_id.get() == "" or self.var_email.get() == ""):
            messagebox.showerror("Error", "All the fields are required")
        else:
            try:
                update = messagebox.askyesno("Update","are you sure?",parent=self.root)
                if update>0:
                    conn = mysql.connector.connect(host="localhost", username="root", password="11608554", database="sms")
                    my_cursor = conn.cursor()
                    my_cursor.execute("update student set Dep=%s, Course=%s,Year=%s,Semester=%s,Name=%s,Division=%s,Roll=%s,Gender=%s,Dob=%s,Email=%s,Phone=%s,Address=%s,Advisor=%s where student_id=%s",
                                      (
                                          self.var_dep.get(),
                                          self.var_course.get(),
                                          self.var_year.get(),
                                          self.var_semester.get(),
                                          self.var_std_name.get(),
                                          self.var_div.get(),
                                          self.var_roll.get(),
                                          self.var_gender.get(),
                                          self.var_dob.get(),
                                          self.var_email.get(),
                                          self.var_phone.get(),
                                          self.var_address.get(),
                                          self.var_teacher.get(),
                                          self.var_std_id.get()
                                      ))
                else:
                    if not update:
                        return
                conn.commit()
                self.fetch_data()
                conn.close()

                messagebox.showinfo("Success","Updated",parent = self.root)
            except Exception as es:
                messagebox.showerror("Error", f"Due to {str(es)}", parent=self.root)

    # Delete Function

    def delete_data(self):
        if self.var_std_id.get()=="":
            messagebox.showerror("Error", "All the fields are required",parent = self.root)
        else:
            try:
                Delete =messagebox.askyesno("Delete","Are you sure delete this data?",parent = self.root)
                if Delete>0:
                    conn = mysql.connector.connect(host="localhost", username="root", password="11608554", database="sms")
                    my_cursor = conn.cursor()
                    sql="delete from student where student_id=%s"
                    value=(self.var_std_id.get(),)
                    my_cursor.execute(sql,value)
                else:
                    if not Delete:
                        return
                conn.commit()
                self.fetch_data()
                conn.close()
                messagebox.showinfo("Delete","Your data has been deleted", parent = self.root)
            except Exception as es:
                messagebox.showerror("Error", f"Due to {str(es)}", parent=self.root)

    # reset function

    def reset_data(self):
        self.var_dep.set("Select Department")
        self.var_course.set("Select Course")
        self.var_year.set("Select Year")
        self.var_semester.set("Select Semester")
        self.var_std_id.set("")
        self.var_std_name.set("")
        self.var_div.set("")
        self.var_roll.set("")
        self.var_gender.set("")
        self.var_dob.set("")
        self.var_email.set("")
        self.var_phone.set("")
        self.var_address.set("")
        self.var_teacher.set("")

    #search
    def search_data(self):
        if self.var_com_search.get()=="" or self.var_search.get()=="":
            messagebox.showerror("Error","Please select option")
        else:
            try:
                conn = mysql.connector.connect(host="localhost", username="root", password="11608554", database="sms")
                my_cursor = conn.cursor()
                my_cursor.execute("select * from student where "+str(self.var_com_search.get())+" LIKE '%"+str(self.var_search.get())+"%'")
                data = my_cursor.fetchall()
                if len(data)!=0:
                    self.student_table.delete(*self.student_table.get_children())
                    for i in data:
                        self.student_table.insert("",END,values=i)
                    conn.commit()
                conn.close()
            except Exception as es:
                messagebox.showerror("Error", f"Due to {str(es)}", parent=self.root)

if __name__=="__main__":
    root = Tk()
    obj = Student(root)
    root.mainloop()