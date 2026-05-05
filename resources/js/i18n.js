import { nextTick, reactive } from 'vue';

const STORAGE_KEY = 'dentist-clinic-locale';

const messages = {
    ar: {
        'Dashboard': 'لوحة التحكم',
        'Doctors': 'الأطباء',
        'Patients': 'المرضى',
        'Appointments': 'المواعيد',
        'Services': 'الخدمات',
        'Service': 'الخدمة',
        'Users': 'المستخدمون',
        'Profile': 'الملف الشخصي',
        'Log Out': 'تسجيل الخروج',
        'Login': 'تسجيل الدخول',
        'Register': 'إنشاء حساب',
        'Logout': 'تسجيل الخروج',
        'Email': 'البريد الإلكتروني',
        'Password': 'كلمة المرور',
        'Remember me': 'تذكرني',
        'Forgot your password?': 'نسيت كلمة المرور؟',
        'Name': 'الاسم',
        'Phone': 'الهاتف',
        'Speciality': 'التخصص',
        'Specialty': 'التخصص',
        'Address': 'العنوان',
        'Age': 'العمر',
        'Gender': 'الجنس',
        'Date': 'التاريخ',
        'Status': 'الحالة',
        'Actions': 'الإجراءات',
        'Search': 'بحث',
        'Filter': 'تصفية',
        'Filters': 'الفلاتر',
        'Reset': 'إعادة ضبط',
        'Clear': 'مسح',
        'Create': 'إنشاء',
        'Edit': 'تعديل',
        'Update': 'تحديث',
        'Delete': 'حذف',
        'Save': 'حفظ',
        'Cancel': 'إلغاء',
        'Back': 'رجوع',
        'View': 'عرض',
        'Show': 'عرض',
        'Details': 'التفاصيل',
        'Submit': 'إرسال',
        'Close': 'إغلاق',
        'Confirm': 'تأكيد',
        'Confirmed': 'مؤكد',
        'confirmed': 'مؤكد',
        'Pending': 'قيد الانتظار',
        'pending': 'قيد الانتظار',
        'Booked': 'محجوز',
        'booked': 'محجوز',
        'Completed': 'مكتمل',
        'completed': 'مكتمل',
        'Cancelled': 'ملغى',
        'cancelled': 'ملغى',
        'Male': 'ذكر',
        'Female': 'أنثى',
        'All': 'الكل',
        'All Doctors': 'كل الأطباء',
        'All Patients': 'كل المرضى',
        'All Services': 'كل الخدمات',
        'All Statuses': 'كل الحالات',
        'Add New Doctor': 'إضافة طبيب جديد',
        'Add Doctor': 'إضافة طبيب',
        'Save Doctor': 'حفظ الطبيب',
        'Edit Doctor': 'تعديل الطبيب',
        'Doctor Profile': 'ملف الطبيب',
        'Doctor Records': 'سجلات الأطباء',
        'Doctor Management': 'إدارة الأطباء',
        'Back to Doctors': 'العودة إلى الأطباء',
        'No doctors found': 'لم يتم العثور على أطباء',
        'Find and connect with our specialist doctors': 'ابحث وتواصل مع أطبائنا المتخصصين',
        'Update doctor basic information': 'تحديث المعلومات الأساسية للطبيب',
        'General Practitioner': 'طبيب عام',
        'Select a doctor': 'اختر طبيباً',
        'Create New Appointment': 'إنشاء موعد جديد',
        'Preferred Appointment Time': 'وقت الموعد المفضل',
        'Service (Optional)': 'الخدمة (اختياري)',
        'No specific service': 'لا توجد خدمة محددة',
        'mins': 'دقائق',
        'Add New Patient': 'إضافة مريض جديد',
        'Add Patient': 'إضافة مريض',
        'Save Patient': 'حفظ المريض',
        'Edit Patient': 'تعديل المريض',
        'Patient Profile': 'ملف المريض',
        'Patient Information': 'معلومات المريض',
        'Patient Management': 'إدارة المرضى',
        'Back to Patients': 'العودة إلى المرضى',
        'No patients found': 'لم يتم العثور على مرضى',
        'Select a patient': 'اختر مريضاً',
        'Patient Records': 'سجلات المرضى',
        'Digital health history': 'سجل صحي رقمي',
        'Create Appointment': 'إنشاء موعد',
        'Add Appointment': 'إضافة موعد',
        'Edit Appointment': 'تعديل الموعد',
        'Appointment Details': 'تفاصيل الموعد',
        'Appointment Information': 'معلومات الموعد',
        'Appointment Management': 'إدارة المواعيد',
        'Appointment Date': 'تاريخ الموعد',
        'Appointment Time': 'وقت الموعد',
        'Back to Appointments': 'العودة إلى المواعيد',
        'No appointments found': 'لم يتم العثور على مواعيد',
        'Select a service': 'اختر خدمة',
        'Our Services': 'خدماتنا',
        'Our': 'خدمات',
        'Dental Services': 'طب الأسنان',
        'Premium dental care tailored to your needs': 'رعاية أسنان مميزة مصممة لاحتياجاتك',
        'Premium dental care with cutting-edge technology and compassionate service.': 'رعاية أسنان مميزة بتقنيات حديثة وخدمة رحيمة.',
        'View Service': 'عرض الخدمة',
        'Back to Home': 'العودة إلى الرئيسية',
        'Doctor Information': 'معلومات الطبيب',
        'Service Information': 'معلومات الخدمة',
        'Create Service': 'إنشاء خدمة',
        'Add Service': 'إضافة خدمة',
        'Edit Service': 'تعديل الخدمة',
        'Service Name': 'اسم الخدمة',
        'Description': 'الوصف',
        'Price': 'السعر',
        'Duration': 'المدة',
        'No services found': 'لم يتم العثور على خدمات',
        'User Management': 'إدارة المستخدمين',
        'User Details': 'تفاصيل المستخدم',
        'Role': 'الدور',
        'Admin': 'مدير',
        'Doctor': 'طبيب',
        'Patient': 'مريض',
        'Super Admin': 'مدير عام',
        'Home': 'الرئيسية',
        'Welcome': 'مرحباً',
        'Clinic Dashboard': 'لوحة تحكم العيادة',
        'Welcome to Your Clinic Portal': 'مرحباً بك في بوابة العيادة',
        'Manage your healthcare operations efficiently': 'أدر عمليات الرعاية الصحية بكفاءة',
        'View and manage patient records and appointments': 'عرض وإدارة سجلات المرضى ومواعيدهم',
        'View and manage all clinic appointments': 'عرض وإدارة كل مواعيد العيادة',
        'View and manage system users and permissions': 'عرض وإدارة مستخدمي النظام والصلاحيات',
        'Go to Users': 'الانتقال إلى المستخدمين',
        'Need help?': 'تحتاج مساعدة؟',
        'Contact support': 'تواصل مع الدعم',
        'Your': 'ابتسامتك',
        'Smile': 'تهمنا',
        'Matters': ' ',
        'Experience premium dental care with our state-of-the-art clinic management system': 'استمتع برعاية أسنان مميزة من خلال نظام إدارة عيادة متطور',
        'Register Now': 'سجل الآن',
        'Easy Scheduling': 'جدولة سهلة',
        'Book appointments in seconds': 'احجز المواعيد خلال ثوان',
        'Professional medical staff': 'طاقم طبي محترف',
        'Quick Links': 'روابط سريعة',
        'About Us': 'من نحن',
        'Our Dentists': 'أطباؤنا',
        'Contact Us': 'اتصل بنا',
        'DentistClinic': 'عيادة الأسنان',
        'Website developed by': 'تم تطوير الموقع بواسطة',
        'All rights reserved.': 'جميع الحقوق محفوظة.',
        'Sitemap': 'خريطة الموقع',
        'Privacy Policy': 'سياسة الخصوصية',
        'Terms of Service': 'شروط الخدمة',
        'Language': 'اللغة',
        'English': 'الإنجليزية',
        'Arabic': 'العربية',
        'Current Password': 'كلمة المرور الحالية',
        'New Password': 'كلمة المرور الجديدة',
        'Confirm Password': 'تأكيد كلمة المرور',
        'Two Factor Authentication': 'المصادقة الثنائية',
        'Browser Sessions': 'جلسات المتصفح',
        'Delete Account': 'حذف الحساب',
        'API Tokens': 'رموز API',
        'Create API Token': 'إنشاء رمز API',
        'Permissions': 'الصلاحيات',
        'Showing': 'عرض',
        'to': 'إلى',
        'of': 'من',
        'results': 'نتائج',
        'Previous': 'السابق',
        'Next': 'التالي',
        'N/A': 'غير متوفر',
        'Go to Doctors': 'الانتقال إلى الأطباء',
        'Manage and view patient information': 'إدارة وعرض معلومات المرضى',
        'Back to Dashboard': 'العودة إلى لوحة التحكم',
        'Go to Patients': 'الانتقال إلى المرضى',
        'Go to Appointments': 'الانتقال إلى المواعيد',
        'View and manage doctor schedules and availability': 'عرض وإدارة جداول الأطباء وتوفرهم',
        'View and manage patient records and information': 'عرض وإدارة سجلات المرضى ومعلوماتهم',
        'Schedule and manage clinic appointments': 'جدولة وإدارة مواعيد العيادة',
        'Try adjusting your search criteria or browse all available doctors.': 'جرّب تعديل معايير البحث أو تصفح كل الأطباء المتاحين.',
        'Try adjusting your search criteria or browse all available patients.': 'جرّب تعديل معايير البحث أو تصفح كل المرضى المتاحين.',
        'Basic Information': 'المعلومات الأساسية',
        'Contact Information': 'معلومات التواصل',
        'Medical Information': 'المعلومات الطبية',
        'Created At': 'تاريخ الإنشاء',
        'Updated At': 'تاريخ التحديث',
        'Search doctors...': 'ابحث عن الأطباء...',
        'Search patients...': 'ابحث عن المرضى...',
        'Search appointments...': 'ابحث عن المواعيد...',
        'Search users...': 'ابحث عن المستخدمين...',
        'Appointments Management': 'إدارة المواعيد',
        'New Appointment': 'موعد جديد',
        'To Date': 'إلى تاريخ',
        'From Date': 'من تاريخ',
        'search by name': 'البحث بالاسم',
        'search by name...': 'البحث بالاسم',
        'search by phone number...': 'البحث برقم الهاتف',
        'all specialties': 'كل التخصصات',
        'pediatric': 'طب الأطفال',
        'cardiology': 'طب القلب',
        'nuerology': 'طب الأعصاب',
        'Braces Consultation': 'استشارة تقويم الأسنان',
        'Whitening': 'تبييض الأسنان',
        'Cavity Filling': 'حشو التجاويف',
        'teeth cleaning': 'تنظيف الأسنان',
        'tooth extraction': 'خلع الأسنان',
    },
};

const textNodes = new WeakMap();

export const i18nState = reactive({
    locale: localStorage.getItem(STORAGE_KEY) || 'en',
});

function normalize(text) {
    return text.replace(/\s+/g, ' ').trim();
}

function hasTranslatableParent(node) {
    let element = node.parentElement;

    while (element) {
        if (element.dataset?.noTranslate !== undefined) {
            return false;
        }

        if (['SCRIPT', 'STYLE', 'TEXTAREA'].includes(element.tagName)) {
            return false;
        }

        element = element.parentElement;
    }

    return true;
}

export function t(value) {
    if (!value || i18nState.locale === 'en') {
        return value;
    }

    const key = normalize(String(value));
    const localeMessages = messages[i18nState.locale] || {};

    return localeMessages[key]
        || localeMessages[key.toLowerCase()]
        || localeMessages[toTitleCase(key)]
        || value;
}

function toTitleCase(value) {
    return value.replace(/\w\S*/g, (word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase());
}

export function setLocale(locale) {
    i18nState.locale = locale;
    localStorage.setItem(STORAGE_KEY, locale);
    applyLocale();
    translatePage();
}

export function toggleLocale() {
    setLocale(i18nState.locale === 'ar' ? 'en' : 'ar');
}

export function applyLocale() {
    const isArabic = i18nState.locale === 'ar';

    document.documentElement.lang = i18nState.locale;
    document.documentElement.dir = isArabic ? 'rtl' : 'ltr';
    document.body.classList.toggle('rtl', isArabic);
}

export async function translatePage() {
    await nextTick();

    const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
    const nodes = [];

    while (walker.nextNode()) {
        nodes.push(walker.currentNode);
    }

    nodes.forEach((node) => {
        if (!hasTranslatableParent(node) || !normalize(node.nodeValue)) {
            return;
        }

        if (!textNodes.has(node)) {
            textNodes.set(node, node.nodeValue);
        }

        const original = textNodes.get(node);
        node.nodeValue = i18nState.locale === 'en' ? original : translateWithSpacing(original);
    });

    document.querySelectorAll('[placeholder], [title], [aria-label]').forEach((element) => {
        ['placeholder', 'title', 'aria-label'].forEach((attribute) => {
            if (!element.hasAttribute(attribute)) {
                return;
            }

            const originalAttribute = `data-i18n-original-${attribute}`;
            const current = element.getAttribute(attribute);

            if (!element.hasAttribute(originalAttribute)) {
                element.setAttribute(originalAttribute, current);
            }

            const original = element.getAttribute(originalAttribute);
            element.setAttribute(attribute, i18nState.locale === 'en' ? original : t(original));
        });
    });
}

function translateWithSpacing(value) {
    const leading = value.match(/^\s*/)?.[0] || '';
    const trailing = value.match(/\s*$/)?.[0] || '';

    return `${leading}${t(value)}${trailing}`;
}

export function installI18n(app) {
    applyLocale();

    app.config.globalProperties.$t = t;
    app.provide('i18n', {
        state: i18nState,
        t,
        setLocale,
        toggleLocale,
    });
}
