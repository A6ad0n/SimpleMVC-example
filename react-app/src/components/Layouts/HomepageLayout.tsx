import Header from './Homepage/Header';
import Footer from './Homepage/Footer';
import type { ReactNode } from 'react';

interface HomepageLayoutProps {
    children: ReactNode;
}

const HomepageLayout: React.FC<HomepageLayoutProps> = ({ children }) => (
  <div className="min-h-screen bg-[#00a0b0]">
    <div className="w-[1000px] bg-white mx-auto my-5 p-5 rounded">
      <Header />
      <main className="my-8">
        {children}
      </main>
      <Footer />
    </div>
  </div>
);

export default HomepageLayout;