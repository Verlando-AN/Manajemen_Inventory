import puppeteer from 'puppeteer-core'; // Menggunakan `puppeteer-core`

const phoneNumber = process.argv[2];
const messageContent = process.argv[3];

(async () => {
  const browser = await puppeteer.launch({
    executablePath: 'C:/Program Files/Google/Chrome/Application/chrome.exe', // Ganti dengan path ke browser Anda
    headless: false
  });

  const page = await browser.newPage();
  
  // Tunggu hingga QR Code dimuat dan pemindaian QR Code dilakukan secara manual
  console.log('Silakan pindai QR Code dengan aplikasi WhatsApp Anda...');
  await page.goto('https://web.whatsapp.com', { timeout: 60000 }); // 60 detik timeout

  // Tunggu hingga elemen input pesan tersedia
  await page.waitForSelector('div[contenteditable="true"]', { visible: true });

  // Navigasi ke chat dengan nomor telepon
  const chatUrl = `https://web.whatsapp.com/send?phone=${phoneNumber}`;
  await page.goto(chatUrl);

  // Tunggu hingga elemen input pesan tersedia
  await page.waitForSelector('div[contenteditable="true"]', { visible: true });
  const messageInput = await page.$('div[contenteditable="true"]');

  // Ketik dan kirim pesan
  await messageInput.type(messageContent);
  await page.keyboard.press('Enter');

  console.log('Pesan dikirim');

  // Tunggu beberapa detik untuk memastikan pesan terkirim
  await page.waitForTimeout(5000);

  await browser.close();
})();
